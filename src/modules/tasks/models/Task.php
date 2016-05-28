<?php

class Task extends Model {

    protected $module = 'tasks';
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = array('*');
    protected $guarded = array('id');
    protected $visible = array('*');
    protected $hidden = array();
    protected $searchable = ['title', 'slug', 'description'];
    protected $perPage = 15;
    protected $sluggable = [
        'slug' => 'title',
    ];
    protected $creatingRules = [
        "title" => "required"
    ];
    protected $updatingRules = [
        "title" => "required"
    ];

    public function users() {
        return $this->belongsToMany('User', 'tasks_users', 'task_id', 'user_id');
    }

    public function groups() {
        return $this->belongsToMany('Group', 'tasks_groups', 'task_id', 'group_id');
    }

    public function user() {
        return $this->hasOne("User", "id", "user_id");
    }

    public function completedUser() {
        return $this->hasOne("User", "id", "completed_by");
    }

    public function tags() {
        return $this->belongsToMany("Tag", "tasks_tags", "task_id", "tag_id");
    }

    public function syncTags($tags) {
        $tag_ids = array();
        if ($tags = @explode(",", $tags)) {
            $tags = array_filter($tags);
            foreach ($tags as $tag_name) {
                $tag = Tag::select("id")->where("name", $tag_name)->first();
                if (count($tag)) {
                    // tag exists
                    $tag_ids[] = $tag->id;
                } else {
                    // create new tag
                    $tag = new Tag();
                    $tag->id = Tag::sequence();
                    $tag->name = $tag_name;
                    $tag->slug = Str::slug($tag_name);
                    $tag->save();
                    $tag_ids[] = $tag->id;
                }
            }
        }
        $this->tags()->sync($tag_ids);
    }

    public function syncUsers($usernames) {
        
        DB::table("tasks_users")->where("group_id", 0)->where("task_id", $this->id)->delete();
        
        $user_ids = array();
        if ($usernames = @explode(",", $usernames)) {
            foreach ($usernames as $username) {
                $user = User::select("id")->where("username", $username)->first();
                if (count($user)) {
                    $user_ids[] = $user->id;
                }
            }
        }

        
        foreach ($user_ids as $user_id) {
            DB::table("tasks_users")->insert(array(
                "task_id" => $this->id,
                "user_id" => $user_id,
                "group_id" => 0
            ));
        }
    }

    public function syncGroups($names) {


        DB::table("tasks_users")->where("group_id", "!=", 0)->where("task_id", $this->id)->delete();
        
        $group_ids = array();
        if ($names = @explode(",", $names)) {
            foreach ($names as $name) {
                $group = Group::select("id")->where("name", $name)->first();
                if (count($group)) {
                    $group_ids[] = $group->id;
                    $user_ids = Group::find($group->id)->users->lists("id")->toArray();
                    foreach ($user_ids as $user_id) {
                        DB::table("tasks_users")->insert(array(
                            "task_id" => $this->id,
                            "user_id" => $user_id,
                            "group_id" => $group->id
                        ));
                    }
                }
            }
        }

        $this->groups()->sync($group_ids);
    }

}
