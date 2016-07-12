<?php

class GroupsController extends Dot\Controller {

    protected $data = [];

    function __construct() {
        parent::__construct();
    }

    function index() {

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

        $this->data["sort"] = (Request::has("sort")) ? Request::get("sort") : "id";
        $this->data["order"] = (Request::has("order")) ? Request::get("order") : "DESC";
        $this->data['per_page'] = (Request::has("per_page")) ? Request::get("per_page") : NULL;

        $query = Group::with('users', 'user')->orderBy($this->data["sort"], $this->data["order"]);


        if (Request::has("user_id")) {
            $query->whereHas("user", function($query) {
                $query->where("users.id", Request::get("user_id"));
            });
        }

        if (Request::has("status")) {
            $query->where("status", Request::get("status"));
        }

        if (Request::has("q")) {
            $query->search(urldecode(Request::get("q")));
        }

        $this->data["groups"] = $query->paginate($this->data['per_page']);
        return View::make("groups::show", $this->data);
    }

    public function create() {
        if (Request::isMethod("post")) {
            $group = new Group();

            $group->name = Request::get('name');
            $group->description = Request::get('description');
            $group->user_id = Auth::user()->id;
            $group->status = Request::get("status", 0);

            // fire group saving action
            Action::fire("group.saving", $group);

            if (!$group->validate()) {
                return Redirect::back()->withErrors($group->errors())->withInput(Request::all());
            }

            $group->save();
            $group->syncUsers(Request::get("users"));

            // fire group saved action
            Action::fire("group.saved", $group);

            return Redirect::route("admin.groups.edit", array("id" => $group->id))
                            ->with("message", trans("groups::groups.events.created"));
        }

        $this->data["group"] = false;
        $this->data["group_users"] = array();

        return View::make("groups::edit", $this->data);
    }

    public function edit($id) {
        $group = Group::findOrFail($id);
        if (Request::isMethod("post")) {

            $group->name = Request::get('name');
            $group->description = Request::get('description');
            $group->status = Request::get("status", 0);

            // fire group saving action
            Action::fire("group.saving", $group);

            if (!$group->validate()) {
                return Redirect::back()->withErrors($group->errors())->withInput(Request::all());
            }

            $group->save();
            $group->syncUsers(Request::get("users"));

            // fire group saved action
            Action::fire("group.saved", $group);

            return Redirect::route("admin.groups.edit", array("id" => $id))->with("message", trans("groups::groups.events.updated"));
        }

        $this->data["group_users"] = $group->users->lists("username")->toArray();
        $this->data["group"] = $group;
        return View::make("groups::edit", $this->data);
    }

    function search() {
        $data = Group::search(urldecode(Request::get("term")))
                ->where("status", 1)
                ->take(6)
                ->get();

        return json_encode($data);
    }

    public function delete() {
        $ids = Request::get("id");
        if (!is_array($ids)) {
            $ids = array($ids);
        }
        foreach ($ids as $ID) {
            $group = Group::findOrFail($ID);

            // fire group deleting action
            Action::fire("group.deleting", $group);

            $group->delete();

            // fire group deleted action
            Action::fire("group.deleted", $group);

        }
        return Redirect::back()->with("message", trans("groups::groups.events.deleted"));
    }

    public function status($status) {
        $ids = Request::get("id");
        if (!is_array($ids)) {
            $ids = array($ids);
        }
        foreach ($ids as $id) {
            $group = Group::findOrFail($id);

            // fire group saving action
            Action::fire("group.saving", $group);

            $group->status = $status;

            // fire group saved action
            Action::fire("group.saved", $group);

            $group->save();
        }

        if ($status) {
            $message = trans("groups::groups.events.activated");
        } else {
            $message = trans("groups::groups.events.deactivated");
        }
        return Redirect::back()->with("message", $message);
    }

}
