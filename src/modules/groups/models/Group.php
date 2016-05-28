<?php

class Group extends Model {

    protected $module = 'groups';
    protected $table = 'groups';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = array('*');
    protected $guarded = array('id');
    protected $visible = array();
    protected $hidden = array();
    protected $searchable = ['name', 'slug', 'description'];
    protected $perPage = 20;
    protected $sluggable = [
        'slug' => 'name',
    ];
    protected $creatingRules = [
        "name" => "required"
    ];
    protected $updatingRules = [
        "name" => "required"
    ];

    public function users() {
        return $this->belongsToMany('User', 'users_groups', 'user_id', 'group_id');
    }

    public function user() {
        return $this->hasOne("User", "id", "user_id");
    }

    public function syncUsers($usernames) {
        $user_ids = array();
        if ($usernames = @explode(",", $usernames)) {
            $usernames = array_filter($usernames);
            foreach ($usernames as $username) {
                $user = User::select("id")->where("username", $username)->first();
                if (count($user)) {
                    $user_ids[] = $user->id;
                }
            }
        }
        $this->users()->sync($user_ids);
    }

}
