<?php

class TagsController extends BackendController
{

    protected $data = [];


    function index()
    {

        if (Request::isMethod("post")) {
            if (Request::has("action")) {
                switch (Request::get("action")) {
                    case "delete":
                        return $this->delete();
                }
            }
        }

        $this->data["sort"] = $sort = (Request::has("sort")) ? Request::get("sort") : "id";
        $this->data["order"] = $order = (Request::has("order")) ? Request::get("order") : "DESC";
        $this->data['per_page'] = (Request::has("per_page")) ? (int)Request::get("per_page") : 40;

        $query = Tag::orderBy($this->data["sort"], $this->data["order"]);

        if (Request::has("q")) {
            $query->search(Request::get("q"));
        }

        $tags = $query->paginate($this->data['per_page']);

        $this->data["tags"] = $tags;

        return View::make("tags::show", $this->data);
    }

    public function create()
    {

        if (Request::isMethod("post")) {

            $tag = new Tag();

            $tag->name = Request::get("name");

            // fire saving tag
            Action::fire("tag.saving", $tag);

            if (!$tag->validate()) {
                return Redirect::back()->withErrors($tag->errors())->withInput(Request::all());
            }

            $tag->save();

            // fire saved action
            Action::fire("tag.saved", $tag);

            return Redirect::route("admin.tags.edit", array("id" => $tag->id))
                ->with("message", trans("tags::tags.events.created"));
        }

        $this->data["tag"] = false;

        return View::make("tags::edit", $this->data);
    }

    public function edit($id)
    {

        $tag = Tag::findOrFail((int)$id);
        if (Request::isMethod("post")) {

            $tag->name = Request::get("name");

            // fire saving action
            Action::fire("tag.saving", $tag);

            if (!$tag->validate()) {
                return Redirect::back()->withErrors($tag->errors())->withInput(Request::all());
            }

            $tag->save();

            // fire saved action
            Action::fire("tag.saved", $tag);

            return Redirect::route("admin.tags.edit", array("id" => $id))->with("message", trans("tags::tags.events.updated"));
        }

        $this->data["tag"] = $tag;

        return View::make("tags::edit", $this->data);
    }

    public function delete()
    {
        $ids = Request::get("id");
        if (!is_array($ids)) {
            $ids = array($ids);
        }
        foreach ($ids as $ID) {
            $tag = Tag::findOrFail((int)$ID);

            // fire deleting action
            Action::fire("tag.deleting", $tag);

            $tag->delete();

            // fire deleted action
            Action::fire("tag.deleted", $tag);
        }
        return Redirect::back()->with("message", trans("tags::tags.events.deleted"));
    }

    function search()
    {

        $q = trim(urldecode(Request::get("q")));

        $tags = Tag::search($q)->get()->toArray();

        return json_encode($tags);
    }
}
