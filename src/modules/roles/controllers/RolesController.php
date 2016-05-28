<?php

class RolesController extends BackendController {

    public $data = array();


    public function __construct()
    {
        parent::__construct();

        if (User::isNot("superadmin")) {
            return denied();
        }
    }

    public function index() {

        if (Request::isMethod("post")) {
            if (Request::has("action")) {
                switch (Request::get("action")) {
                    case "delete":
                        return $this->delete();
                }
            }
        }

        $query = Role::orderBy("id", "ASC");

        if (Request::has("q")) {
            $query->search(Request::get("q"));
        }

        if (Request::has("per_page")) {
            $this->data["per_page"] = $per_page = Request::get("per_page");
        } else {
            $this->data["per_page"] = $per_page = 20;
        }


        $this->data["roles"] = $query->paginate($per_page);


       // dd($this->data["roles"]);


        return View::make("roles::show", $this->data);
    }

    public function create() {

        if (Request::isMethod("post")) {

            $role = new Role();

            $role->name = Request::get("name");

            if(!$role->validate()){
                return Redirect::back()->withErrors($role->errors())->withInput(Request::all());
            }

            $role->save();

            $role->savePermissions();

            return Redirect::route("admin.roles.edit", array("id" => $role->id))->with("message", trans("roles::roles.role_created"));
        }


        $this->data["role"] = false;
        $this->data["modules"] = Config::get("admin.modules");

        return View::make("roles::edit", $this->data);
    }

    public function edit($id) {

        $role = Role::findOrFail($id);

        if (Request::isMethod("post")) {

            $role->name = Request::get("name");

            if(!$role->validate()){
                return Redirect::back()->withErrors($role->errors())->withInput(Request::all());
            }

            $role->save();

            $role->savePermissions();

            return Redirect::back()->with("message", trans("roles::roles.role_updated"));
        }

        $this->data["role"] = $role;
        $this->data["role_permissions"] = $role->permissions->lists("permission")->toArray();

        $this->data["modules"] = Config::get("admin.modules");

        return View::make("roles::edit", $this->data);
    }


    public function delete()
    {
        $ids = Request::get("id");
        if (!is_array($ids)) {
            $ids = array($ids);
        }

        foreach ($ids as $ID) {
            $user = Role::findOrFail($ID);
            $user->delete();
        }
        return Redirect::back()->with("message", trans("roles::roles.role_deleted"));
    }


}
