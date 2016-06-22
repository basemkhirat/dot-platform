<?php

class PostsController extends BackendController
{

    protected $data = [];

    function __construct()
    {
        parent::__construct();
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

        $query = Post::with('image', 'user', 'tags')->orderBy($this->data["sort"], $this->data["order"]);

        if (Request::has("tag_id")) {
            $query->whereHas("tags", function ($query) {
                $query->where("tags.id", Request::get("tag_id"));
            });
        }

        if (Request::has("category_id") and Request::get("category_id") != 0) {
            $query->whereHas("categories", function ($query) {
                $query->where("categories.id", Request::get("category_id"));
            });
        }

        if (Request::has("from")) {
            $query->where("updated_at", ">=", Request::get("from"));
        }

        if (Request::has("to")) {
            $query->where("updated_at", "<=", Request::get("to"));
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
        $this->data["posts"] = $query->paginate($this->data['per_page']);

        return View::make("posts::show", $this->data);
    }

    public function create()
    {
        $post = new Post();
        if (Request::isMethod("post")) {

            $post->title = Request::get('title');
            $post->excerpt = Request::get('excerpt');
            $post->content = Request::get('content');
            $post->image_id = Request::get('image_id');
            $post->media_id = Request::get('media_id');
            $post->user_id = Auth::user()->id;
            $post->status = Request::get("status", 0);
            $post->format = Request::get("format", "post");

            // fire post saving action
            Action::fire("post.saving", $post);

            if (!$post->validate()) {
                return Redirect::back()->withErrors($post->errors())->withInput(Request::all());
            }

            $post->save();

            $post->syncTags(Request::get("tags", []));
            $post->categories()->sync(Request::get("categories", []));

            // fire  saved action
            Action::fire("post.saved", $post);

            return Redirect::route("admin.posts.edit", array("id" => $post->id))
                ->with("message", trans("posts::posts.events.created"));
        }


        $this->data["post_tags"] = array();
        $this->data["post_categories"] = collect([]);
        $this->data["post"] = $post;

        return View::make("posts::edit", $this->data);
    }

    public function edit($id)
    {

        $post = Post::findOrFail($id);

        if (Request::isMethod("post")) {

            $post->title = Request::get('title');
            $post->excerpt = Request::get('excerpt');
            $post->content = Request::get('content');
            $post->image_id = Request::get('image_id');
            $post->media_id = Request::get('media_id');
            $post->status = Request::get("status", 0);
            $post->format = Request::get("format", "post");

            // fire post saving action
            Action::fire("post.saving", $post);

            if (!$post->validate()) {
                return Redirect::back()->withErrors($post->errors())->withInput(Request::all());
            }

            $post->save();

            $post->syncTags(Request::get("tags", []));
            $post->categories()->sync(Request::get("categories", []));

            // fire post saved action
            Action::fire("post.saved", $post);

            return Redirect::route("admin.posts.edit", array("id" => $id))->with("message", trans("posts::posts.events.updated"));
        }

        $this->data["post_tags"] = $post->tags->lists("name")->toArray();
        $this->data["post_categories"] = $post->categories;
        $this->data["post"] = $post;

        return View::make("posts::edit", $this->data);
    }

    public function delete()
    {
        $ids = Request::get("id");
        if (!is_array($ids)) {
            $ids = array($ids);
        }
        foreach ($ids as $ID) {
            $post = Post::findOrFail($ID);

            // fire post deleting action
            Action::fire("post.deleting", $post);

            $post->tags()->detach();
            $post->categories()->detach();

            $post->delete();

            // fire post deleted action
            Action::fire("post.deleted", $post);
        }
        return Redirect::back()->with("message", trans("posts::posts.events.deleted"));
    }

    public function status($status)
    {
        $ids = Request::get("id");
        if (!is_array($ids)) {
            $ids = array($ids);
        }
        foreach ($ids as $id) {
            $post = Post::findOrFail($id);

            // fire post saving action
            Action::fire("post.saving", $post);

            $post->status = $status;
            $post->save();

            // fire post saved action
            Action::fire("post.saved", $post);
        }

        if ($status) {
            $message = trans("posts::posts.events.activated");
        } else {
            $message = trans("posts::posts.events.deactivated");
        }
        return Redirect::back()->with("message", $message);
    }

}
