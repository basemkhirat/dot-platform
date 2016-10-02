<?php

class CategoriesController extends Dot\Controller {

    protected $data = [];

    function __construct()
    {
        parent::__construct();
        $this->middleware("permission:categories.manage");
    }

    function index($parent = 0) {

        if (Request::isMethod("post")) {
            if (Request::has("action")) {
                switch (Request::get("action")) {
                    case "delete":
                        return $this->delete();
                }
            }
        }

        $this->data["sort"] = (Request::has("sort")) ? Request::get("sort") : "id";
        $this->data["order"] = (Request::has("order")) ? Request::get("order") : "DESC";
        $this->data['per_page'] = (Request::has("per_page")) ? Request::get("per_page") : NULL;

        $query = Category::parent($parent)->orderBy($this->data["sort"], $this->data["order"]);

        if (Request::has("q")) {
            $query->search(urldecode(Request::get("q")));
        }

        $this->data["categories"] = $query->paginate($this->data['per_page']);
        return View::make("categories::show", $this->data);
    }

    public function create() {

        if (Request::isMethod("post")) {

            $category = new Category();

            $category->name = Request::get('name');
            $category->slug = Request::get('slug');
            $category->image_id = Request::get('image_id');
            $category->parent = Request::get('parent');
            $category->lang = LANG;

            // fire category saving action
            Action::fire("category.saving", $category);

            if (!$category->validate()) {
                return Redirect::back()->withErrors($category->errors())->withInput(Request::all());
            }

            $category->save();

            // fire category saved action
            Action::fire("category.saved", $category);

            return Redirect::route("admin.categories.edit", array("id" => $category->id))
                            ->with("message", trans("categories::categories.events.created"));
        }

        $this->data["category"] = false;
        return View::make("categories::edit", $this->data);
    }

    public function edit($id) {

        $category = Category::findOrFail($id);
        if (Request::isMethod("post")) {

            $category->name = Request::get('name');
            $category->slug = Request::get('slug');
            $category->image_id = Request::get('image_id');
            $category->parent = Request::get('parent');
            $category->lang = LANG;

            // fire category saving action
            Action::fire("category.saving", $category);

            if (!$category->validate()) {
                return Redirect::back()->withErrors($category->errors())->withInput(Request::all());
            }

            $category->save();

            // fire category saved action
            Action::fire("category.saved", $category);

            return Redirect::route("admin.categories.edit", array("id" => $id))->with("message", trans("categories::categories.events.updated"));
        }

        $this->data["category"] = $category;
        return View::make("categories::edit", $this->data);
    }

    public function delete() {
        $ids = Request::get("id");
        if (!is_array($ids)) {
            $ids = array($ids);
        }
        foreach ($ids as $ID) {
            $category = Category::findOrFail($ID);

            // fire category deleting action
            Action::fire("category.deleting", $category);

            $category->delete();

            // fire category deleted action
            Action::fire("category.deleted", $category);

        }
        return Redirect::back()->with("message", trans("categories::categories.events.deleted"));
    }

}
