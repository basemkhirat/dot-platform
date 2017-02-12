<?php

class PagesController extends Dot\Controller
{

    protected $data = [];

    function __construct()
    {
        parent::__construct();
        $this->middleware("permission:pages.manage");

    }

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

        $this->data["sort"] = (Request::has("sort")) ? Request::get("sort") : "created_at";
        $this->data["order"] = (Request::has("order")) ? Request::get("order") : "DESC";
        $this->data['per_page'] = (Request::has("per_page")) ? Request::get("per_page") : NULL;

        $query = Page::with('image', 'user', 'tags')->orderBy($this->data["sort"], $this->data["order"]);

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
        $this->data["pages"] = $query->paginate($this->data['per_page']);

        return View::make("pages::show", $this->data);
    }

    public function create()
    {
        $page = new Page();
        if (Request::isMethod("post")) {


            $page->title = Request::get('title');
            $page->slug = Request::get('slug');
            $page->excerpt = Request::get('excerpt');
            $page->content = Request::get('content');
            $page->image_id = Request::get('image_id');
            $page->user_id = Auth::user()->id;
            $page->status = Request::get("status", 0);
            $page->lang = app()->getLocale();


            // fire page saving action
            Action::fire("page.saving", $page);

            if (!$page->validate()) {
                return Redirect::back()->withErrors($page->errors())->withInput(Request::all());
            }

            $page->save();

            $page->syncTags(Request::get("tags"));

            // fire  saved action
            Action::fire("page.saved", $page);

            return Redirect::route("admin.pages.edit", array("id" => $page->id))
                ->with("message", trans("pages::pages.events.created"));
        }


        $this->data["page_tags"] = array();
        $this->data["page"] = $page;

        return View::make("pages::edit", $this->data);
    }

    public function edit($id)
    {



        $page = Page::findOrFail($id);


        if (Request::isMethod("post")) {

            $page->slug = Request::get('slug');
            $page->title = Request::get('title');
            $page->excerpt = Request::get('excerpt');
            $page->content = Request::get('content');
            $page->image_id = Request::get('image_id');
            $page->status = Request::get("status", 0);
            $page->lang = app()->getLocale();

            // fire page saving action
            Action::fire("page.saving", $page);

            if (!$page->validate()) {
                return Redirect::back()->withErrors($page->errors())->withInput(Request::all());
            }

            $page->save();
            $page->syncTags(Request::get("tags"));

            // fire page saved action
            Action::fire("page.saved", $page);

            return Redirect::route("admin.pages.edit", array("id" => $id))->with("message", trans("pages::pages.events.updated"));
        }


        $this->data["page_tags"] = $page->tags->pluck("name")->toArray();

        $this->data["page"] = $page;

        return View::make("pages::edit", $this->data);
    }

    public function delete()
    {
        $ids = Request::get("id");
        if (!is_array($ids)) {
            $ids = array($ids);
        }
        foreach ($ids as $ID) {
            $page = Page::findOrFail($ID);

            // fire page deleting action
            Action::fire("page.deleting", $page);

            $page->tags()->detach();
            $page->delete();

            // fire page deleted action
            Action::fire("page.deleted", $page);
        }
        return Redirect::back()->with("message", trans("pages::pages.events.deleted"));
    }

    public function status($status)
    {
        $ids = Request::get("id");
        if (!is_array($ids)) {
            $ids = array($ids);
        }
        foreach ($ids as $id) {
            $page = Page::findOrFail($id);

            // fire page saving action
            Action::fire("page.saving", $page);

            $page->status = $status;
            $page->save();

            // fire page saved action
            Action::fire("page.saved", $page);
        }

        if ($status) {
            $message = trans("pages::pages.events.activated");
        } else {
            $message = trans("pages::pages.events.deactivated");
        }
        return Redirect::back()->with("message", $message);
    }

}
