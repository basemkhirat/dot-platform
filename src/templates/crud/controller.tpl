<?php

class #module|ucfirst#Controller extends Dot\Controller {

    protected $data = [];

    function __construct(){
        parent::__construct();
    }

    function index(){

        if (Request::isMethod("post")) {
            if (Request::has("action")) {
                switch (Request::get("action")) {
                    case "delete":
                        return $this->delete();
                    {if options.status}
                    case "activate":
                        return $this->status(1);
                    case "deactivate":
                        return $this->status(0);
                    {/if}
                }
            }
        }

        $this->data["sort"] = (Request::has("sort")) ? Request::get("sort") : "#key#";
        $this->data["order"] = (Request::has("order")) ? Request::get("order") : "DESC";
        $this->data['per_page'] = (Request::has("per_page")) ? Request::get("per_page") : NULL;

        $query = #model|ucfirst#::#loaded_models#orderBy($this->data["sort"], $this->data["order"]);

        {if module.tags}
        if (Request::has("tag_id")) {
            $query->whereHas("tags", function($query) {
                $query->where("tags.id", Request::get("tag_id"));
            });
        }
        {/if}
        {if module.categories}
        if (Request::has("category_id")) {
            $query->whereHas("categories", function($query) {
                $query->where("categories.id", Request::get("category_id"));
            });
        }
        {/if}
        {if module.user}
        if (Request::has("user_id")) {
            $query->whereHas("user", function($query) {
                $query->where("users.id", Request::get("user_id"));
            });
        }
        {/if}
        {if options.status}
        if (Request::has("status")) {
            $query->where("status", Request::get("status"));
        }
        {/if}
        if (Request::has("q")) {
            $query->search(urldecode(Request::get("q")));
        }
        $this->data["#module#"] = $query->paginate($this->data['per_page']);
        return View::make("#module#::show", $this->data);

    }

    public function create() {

        if (Request::isMethod("post")) {

            $#model# = new #model|ucfirst#();
            [loop attributes as attribute]
            $#model#->#attribute# = Request::get('#attribute#');
            [/loop]
            {if module.image}
            $#model#->image_id = Request::get('image_id');
            {/if}
            {if module.user}
            $#model#->user_id = Auth::user()->id;
            {/if}
            {if options.status}
            $#model#->status = Request::get("status", 0);
            {/if}

            if(!$#model#->validate()){
                return Redirect::back()->withErrors($#model#->errors())->withInput(Request::all());
            }

            $#model#->save();
            {if module.categories}
            $#model#->syncCategories(Request::get("categories"));
            {/if}
            {if module.tags}
            $#model#->syncTags(Request::get("tags"));
            {/if}

            return Redirect::route("admin.#module#.edit", array("#key#" => $#model#->#key#))
                    ->with("message", trans("#module#::#module#.events.created"));
        }
        {if module.categories}
        $this->data["#model#_categories"] = array();
        {/if}
        {if module.tags}
        $this->data["#model#_tags"] = array();
        {/if}
        $this->data["#model#"] = false;
        return View::make("#module#::edit", $this->data);
    }

    public function edit($#key#) {

        $#model# = #model|ucfirst#::findOrFail($#key#);

        if (Request::isMethod("post")) {

            [loop attributes as attribute]
            $#model#->#attribute# = Request::get('#attribute#');
            [/loop]
            {if module.image}
            $#model#->image_id = Request::get('image_id');
            {/if}
            {if options.status}
            $#model#->status = Request::get("status", 0);
            {/if}

            if(!$#model#->validate()){
                return Redirect::back()->withErrors($#model#->errors())->withInput(Request::all());
            }

            $#model#->save();
            {if module.categories}
            $#model#->syncCategories(Request::get("categories"));
            {/if}
            {if module.tags}
            $#model#->syncTags(Request::get("tags"));
            {/if}

            return Redirect::route("admin.#module#.edit", array("#key#" => $#key#))->with("message", trans("#module#::#module#.events.updated"));
        }

        {if module.categories}
        $this->data["#model#_categories"] = $#model#->categories->pluck("id")->toArray();
        {/if}
        {if module.tags}
        $this->data["#model#_tags"] = $#model#->tags->pluck("name")->toArray();
        {/if}
        $this->data["#model#"] = $#model#;
        return View::make("#module#::edit", $this->data);
    }

    public function delete() {

        $ids = Request::get("#key#");

        if (!is_array($ids)) {
            $ids = array($ids);
        }

        foreach ($ids as $ID) {
            $#model# = #model|ucfirst#::findOrFail($ID);
            {if module.categories}
            $#model#->categories()->detach();
            {/if}
            {if module.tags}
            $#model#->tags()->detach();
            {/if}
            $#model#->delete();
        }

        return Redirect::back()->with("message", trans("#module#::#module#.events.deleted"));
    }
    {if options.status}
    public function status($status) {

        $ids = Request::get("#key#");

        if (!is_array($ids)) {
            $ids = array($ids);
        }

        foreach ($ids as $#key#) {
            $#model# = #model|ucfirst#::findOrFail($#key#);
            $#model#->status = $status;
            $#model#->save();
        }

        if($status){
            $message = trans("#module#::#module#.events.activated");
        }else{
            $message = trans("#module#::#module#.events.deactivated");
        }

        return Redirect::back()->with("message", $message);
    }
    {/if}

}
