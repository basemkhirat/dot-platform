<?php

/**
 * Class UsersController
 */
class UsersController extends BackendController
{

    /**
     * @var array
     */
    public $data = array();


    /**
     * @return mixed
     */
    public function index()
    {
        if (Request::isMethod("post")) {
            if (Request::has("action")) {
                switch (Request::get("action")) {
                    case "delete":
                        return $this->delete();
                }
            }
        }

        $this->data["sort"] = (Request::has("sort")) ? Request::get("sort") : "created_at";
        $this->data["order"] = (Request::has("order")) ? Request::get("order") : "DESC";
        $this->data['per_page'] = (Request::has("per_page")) ? Request::get("per_page") : 20;


        $query = User::with("role", "photo")->orderBy($this->data["sort"], $this->data["order"]);

        if (Request::has("q")) {
            $q = urldecode(Request::get("q"));
            $query->search($q);
        }

        if (Request::has("per_page")) {
            $this->data["per_page"] = $per_page = Request::get("per_page");
        } else {
            $this->data["per_page"] = $per_page = 20;
        }

        if (Request::has("backend") and Request::get("backend") == 1) {
            $query->where("role_id", "!=", 0);
        }

        if (Request::has("status")) {
            $query->where("status", Request::get("status"));
        }

        if (Request::has("role_id")) {
            $query->where("role_id", Request::get("role_id"));
        }

        $this->data["users"] = $query->paginate($per_page);
        $this->data["roles"] = Role::all();

        return View::make("users::show", $this->data);
    }

    /**
     * @return string
     */
    public function create()
    {
        if (!User::access("users.create")) {
            return denied();
        }

        if (Request::isMethod("post")) {

            $user = new User(Request::all());

            if (!$user->validate()) {
                return Redirect::back()->withErrors($user->errors())->withInput(Request::all());
            }

            $user->save();

            return Redirect::route("admin.users.edit", array("id" => $user->id))
                ->with("message", trans("users::users.user_created"));


        }

        $this->data["user"] = false;
        $this->data["roles"] = Role::all();

        return View::make("users::edit", $this->data);
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function edit($user_id)
    {

        $user = User::with("photo")->where("id", $user_id)->first();

        if (count($user) == 0) {
            abort(404);
        }

        if (Request::isMethod("post")) {

            $user->fill(Request::all());

            if (!$user->validate()) {
                return Redirect::route("admin.users.edit", array("id" => $user_id))->with("message", trans("users::users.user_updated"));
            }

            $user->save();

            return Redirect::back()->withErrors($user->errors())->withInput(Request::all());


        }

        $this->data["user"] = $user;
        $this->data["roles"] = Role::all();

        return View::make("users::edit", $this->data);
    }

    /**
     * @return string
     */
    function search()
    {
        $data = User::search(urldecode(Request::get("term")))
            ->take(6)
            ->get();
        return json_encode($data);
    }

    /**
     * @return string
     */
    public function delete()
    {
        $ids = Request::get("id");
        if (!is_array($ids)) {
            $ids = array($ids);
        }

        foreach ($ids as $ID) {
            $user = User::findOrFail($ID);
            $user->delete();
        }
        return Redirect::back()->with("message", trans("users::users.user_deleted"));
    }

}
