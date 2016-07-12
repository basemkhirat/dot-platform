<?php

class BlocksController extends Dot\Controller
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

        $query = Block::orderBy($this->data["sort"], $this->data["order"]);

        if (Request::has("q")) {
            $query->search(Request::get("q"));
        }

        $blocks = $query->paginate($this->data['per_page']);

        $this->data["blocks"] = $blocks;

        return View::make("blocks::show", $this->data);
    }

    public function create()
    {

        if (Request::isMethod("post")) {

            $block = new Block();

            $block->name = Request::get("name");
            $block->type = Request::get("type");
            $block->limit = Request::get("limit", 0);
            $block->lang = LANG;

            // fire saving block
            Action::fire("block.saving", $block);

            if (!$block->validate()) {
                return Redirect::back()->withErrors($block->errors())->withInput(Request::all());
            }

            $block->save();
            $block->syncTags(Request::get("tags", []));
            $block->categories()->sync(Request::get("categories", []));

            // fire saved action
            Action::fire("block.saved", $block);

            return Redirect::route("admin.blocks.edit", array("id" => $block->id))
                ->with("message", trans("blocks::blocks.events.created"));
        }

        $this->data["block"] = false;
        $this->data["block_tags"] = array();
        $this->data["block_categories"] = collect([]);

        return View::make("blocks::edit", $this->data);
    }

    public function edit($id)
    {

        $block = Block::findOrFail((int)$id);
        if (Request::isMethod("post")) {

            $block->name = Request::get("name");
            $block->type = Request::get("type");
            $block->limit = Request::get("limit", 0);
            $block->lang = LANG;

            // fire saving action
            Action::fire("block.saving", $block);

            if (!$block->validate()) {
                return Redirect::back()->withErrors($block->errors())->withInput(Request::all());
            }

            $block->save();
            $block->syncTags(Request::get("tags", []));
            $block->categories()->sync(Request::get("categories", []));

            // fire saved action
            Action::fire("block.saved", $block);

            return Redirect::route("admin.blocks.edit", array("id" => $id))->with("message", trans("blocks::blocks.events.updated"));
        }

        $this->data["block"] = $block;
        $this->data["block_tags"] = $block->tags->lists("name")->toArray();
        $this->data["block_categories"] = $block->categories;

        return View::make("blocks::edit", $this->data);
    }

    public function delete()
    {
        $ids = Request::get("id");
        if (!is_array($ids)) {
            $ids = array($ids);
        }
        foreach ($ids as $ID) {
            $block = Block::findOrFail((int)$ID);

            // fire deleting action
            Action::fire("block.deleting", $block);

            $block->delete();
            $block->tags()->detach();
            $block->categories()->detach();

            // fire deleted action
            Action::fire("block.deleted", $block);
        }
        return Redirect::back()->with("message", trans("blocks::blocks.events.deleted"));
    }

    function search()
    {

        $q = trim(urldecode(Request::get("q")));

        $blocks = Block::search($q)->get()->toArray();

        return json_encode($blocks);
    }
}
