<?php

class TasksController extends BackendController {

    protected $data = [];

    function __construct() {
        parent::__construct();
    }

    function index() {


       // dd(Auth::user()->photo());

        if (Request::isMethod("post")) {
            if (Request::has("action")) {
                switch (Request::get("action")) {
                    case "delete":
                        return $this->delete();
                    case "activate":
                        return $this->status(1);
                    case "deactivate":
                        return $this->status(0);
                    case "complete":
                        return $this->done(1);
                    case "uncomplete":
                        return $this->done(0);
                }
            }
        }

        $this->data["sort"] = (Request::has("sort")) ? Request::get("sort") : "created_at";
        $this->data["order"] = (Request::has("order")) ? Request::get("order") : "DESC";
        $this->data['per_page'] = (Request::has("per_page")) ? Request::get("per_page") : NULL;

        $query = Task::with('users', 'groups', 'user', 'tags')->orderBy($this->data["sort"], $this->data["order"]);
        if (Request::has("tag_id")) {
            $query->whereHas("tags", function($query) {
                $query->where("tags.tag_id", Request::get("tag_id"));
            });
        }

        if (Request::has("user_id")) {
            $query->whereHas("user", function($query) {
                $query->where("users.id", Request::get("user_id"));
            });
        }
        if (Request::has("status")) {
            $query->where("status", Request::get("status"));
        }

        if (Request::has("done")) {
            $query->where("done", Request::get("done"));
        }

        if (Request::has("q")) {
            $query->search(urldecode(Request::get("q")));
        }
        $this->data["tasks"] = $query->paginate($this->data['per_page']);



        return View::make("tasks::show", $this->data);
    }

    public function create() {
        if (Request::isMethod("post")) {
            $task = new Task();

            $task->title = Request::get('title');
            $task->description = Request::get('description');
            $task->start_date = Request::get('start_date');
            $task->end_date = Request::get('end_date');
            $task->done = Request::get('done');

            $task->user_id = Auth::user()->id;
            $task->status = Request::get("status", 0);

            if (!$task->validate()) {
                return Redirect::back()->withErrors($task->errors())->withInput(Request::all());
            }

            $task->save();
            $task->syncGroups(Request::get("groups"));
            $task->syncUsers(Request::get("users"));
            $task->syncTags(Request::get("tags"));

            return Redirect::route("admin.tasks.edit", array("id" => $task->id))
                            ->with("message", trans("tasks::tasks.events.created"));
        }

        $this->data["task_tags"] = array();
        $this->data["task_groups"] = array();
        $this->data["task_users"] = array();
        $this->data["task"] = false;
        return View::make("tasks::edit", $this->data);
    }

    public function edit($id) {
        $task = Task::findOrFail($id);
        if (Request::isMethod("post")) {


            $task->title = Request::get('title');
            $task->description = Request::get('description');
            $task->start_date = Request::get('start_date');
            $task->end_date = Request::get('end_date');
            $task->done = Request::get('done');

            $task->status = Request::get("status", 0);

            if (!$task->validate()) {
                return Redirect::back()->withErrors($task->errors())->withInput(Request::all());
            }

            $task->save();
            $task->syncGroups(Request::get("groups"));
            $task->syncUsers(Request::get("users"));
            $task->syncTags(Request::get("tags"));

            return Redirect::route("admin.tasks.edit", array("id" => $id))->with("message", trans("tasks::tasks.events.updated"));
        }


        $this->data["task_tags"] = $task->tags->lists("name")->toArray();
        $this->data["task_groups"] = $task->groups->lists("name")->toArray();
        $this->data["task_users"] = $task->users->lists("username")->toArray();

        $this->data["task_users"] = DB::table("tasks_users")
                ->join("users", "users.id", "=", "tasks_users.user_id")
                ->where("group_id", 0)
                ->where("task_id", $id)
                ->lists("users.username");

        $this->data["task"] = $task;
        return View::make("tasks::edit", $this->data);
    }

    public function delete() {
        $ids = Request::get("id");
        if (!is_array($ids)) {
            $ids = array($ids);
        }
        foreach ($ids as $ID) {
            $task = Task::findOrFail($ID);

            $task->tags()->detach();
            $task->groups()->detach();
            $task->users()->detach();

            $task->delete();
        }
        return Redirect::back()->with("message", trans("tasks::tasks.events.deleted"));
    }

    public function status($status) {
        $ids = Request::get("id");
        if (!is_array($ids)) {
            $ids = array($ids);
        }
        foreach ($ids as $id) {
            $task = Task::findOrFail($id);
            $task->status = $status;
            $task->save();
        }

        if ($status) {
            $message = trans("tasks::tasks.events.activated");
        } else {
            $message = trans("tasks::tasks.events.deactivated");
        }
        return Redirect::back()->with("message", $message);
    }

    public function done($status) {

        $ids = Request::get("id");
        if (!is_array($ids)) {
            $ids = array($ids);
        }

        foreach ($ids as $id) {
            $task = Task::findOrFail($id);
            $task->done = $status;
            if ($status == 1) {
                $task->completed_at = date("Y-m-d H:i:S");
                $task->completed_by = Auth::user()->id;
            } else {
                $task->completed_at = "0000-00-00 00:00:00";
                $task->completed_by = 0;
            }
            $task->save();
        }

        if (!Request::ajax()) {
            if ($status) {
                $message = trans("tasks::tasks.events.completed");
            } else {
                $message = trans("tasks::tasks.events.uncompleted");
            }
            return Redirect::back()->with("message", $message);
        }
    }

}
