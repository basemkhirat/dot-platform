<?php

class PollsController extends Dot\Controller
{
    protected $data = [];

    function index()
    {

        if (Request::isMethod("post")) {
            if (Request::has("action")) {
                switch (Request::get("action")) {
                    case "delete":
                        return $this->delete();
                    case "activate":
                        return $this->status(1);
                    case "deactivate":
                        return $this->status(0);
                }
            }
        }

        $this->data["sort"] = (Request::has("sort")) ? Request::get("sort") : "status";
        $this->data["order"] = (Request::has("order")) ? Request::get("order") : "DESC";
        $this->data['per_page'] = (Request::has("per_page")) ? Request::get("per_page") : NULL;

        $query = Poll::with('image', 'user', 'tags')
            ->where("parent", 0)
            ->orderBy($this->data["sort"], $this->data["order"]);

        if (Request::has("tag_id")) {
            $query->whereHas("tags", function ($query) {
                $query->where("tags.id", Request::get("tag_id"));
            });
        }

        if (Request::has("user_id")) {
            $query->whereHas("user", function ($query) {
                $query->where("users.id", Request::get("user_id"));
            });
        }

        if (Request::has("status")) {
            $query->where("status", Request::get("status"));
        }

        if (Request::has("q")) {
            $query->search(urldecode(Request::get("q")));
        }

        $this->data["polls"] = $query->paginate($this->data['per_page']);
        return View::make("polls::show", $this->data);
    }

    public function create()
    {

        $poll = new Poll();

        if (Request::isMethod("post")) {

            $poll->parent = 0;
            $poll->title = Request::get('title');
            $poll->lang = app()->getLocale();
            $poll->image_id = Request::get('image_id', 0);
            $poll->user_id = Auth::user()->id;
            $poll->status = Request::get("status", 0);

            if (!$poll->validate()) {
                return Redirect::back()->withErrors($poll->errors())->withInput(Request::all());
            }

            $poll->save();
            $poll->syncTags(Request::get("tags"));

            // Saving answers
            Poll::where("parent", $poll->id)->delete();
            foreach(Request::get("answers", []) as $answer_title){

                if($answer_title == ""){
                    continue;
                }

                $answer = new Poll();

                $answer->parent = $poll->id;
                $answer->title = $answer_title;
                $answer->lang = app()->getLocale();
                $answer->user_id = Auth::user()->id;
                $answer->status = Request::get('status', 0);

                $answer->save();

            }

            return Redirect::route("admin.polls.edit", array("id" => $poll->id))
                ->with("message", trans("polls::polls.events.created"));
        }

        $this->data["poll_tags"] = array();
        $this->data["poll"] = $poll;
        return View::make("polls::edit", $this->data);

    }

    public function edit($id)
    {

        $poll = Poll::findOrFail($id);

        if (Request::isMethod("post")) {

            Poll::where("id", "!=", $id)->update([
                "status" => 0
            ]);

            $poll->parent = 0;
            $poll->title = Request::get('title');
            $poll->lang = app()->getLocale();
            $poll->image_id = Request::get('image_id', 0);
            $poll->status = Request::get("status", 0);

            if (!$poll->validate()) {
                return Redirect::back()->withErrors($poll->errors())->withInput(Request::all());
            }

            $poll->save();
            $poll->syncTags(Request::get("tags"));

            $answers_images = Request::get("images", []);

            // Saving answers
            Poll::where("parent", $poll->id)->delete();

            $i = 0;
            foreach(Request::get("answers", []) as $answer_title){

                if($answer_title == ""){
                    continue;
                }

                $answer = new Poll();

                $answer->parent = $poll->id;
                $answer->title = $answer_title;
                $answer->lang = app()->getLocale();
                $answer->user_id = Auth::user()->id;
                $answer->image_id = $answers_images[$i];
                $answer->status = Request::get('status', 0);

                $answer->save();

                $i++;
            }


            return Redirect::route("admin.polls.edit", array("id" => $id))->with("message", trans("polls::polls.events.updated"));
        }

        $this->data["poll_tags"] = $poll->tags->pluck("name")->toArray();
        $this->data["poll"] = $poll;
        return View::make("polls::edit", $this->data);
    }

    public function delete()
    {

        $ids = Request::get("id");
        if (!is_array($ids)) {
            $ids = array($ids);
        }
        foreach ($ids as $ID) {
            $poll = Poll::findOrFail($ID);

            $poll->tags()->detach();
            $poll->delete();
        }
        return Redirect::back()->with("message", trans("polls::polls.events.deleted"));
    }

    public function status($status)
    {
        $ids = Request::get("id");
        if (!is_array($ids)) {
            $ids = array($ids);
        }
        foreach ($ids as $id) {

            Poll::where("id", "!=", $id)->update([
                "status" => 0
            ]);

            $poll = Poll::findOrFail($id);
            $poll->status = $status;
            $poll->save();
        }
        if ($status) {
            $message = trans("polls::polls.events.activated");
        } else {
            $message = trans("polls::polls.events.deactivated");
        }
        return Redirect::back()->with("message", $message);
    }
}
