<?php

use Carbon\Carbon;

class Post extends Model {

    protected $module = 'posts';

    protected $table = 'posts';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $searchable = ['title', 'excerpt', 'content'];
    protected $perPost = 20;

    protected $sluggable = [
        'slug' => 'title',
    ];

    protected $creatingRules = [
        'title' => 'required'
    ];

    protected $updatingRules = [
        'title' => 'required'
    ];

    public function image() {
        return $this->hasOne("Media", "id", "image_id");
    }

    public function media() {
        return $this->hasOne("Media", "id", "media_id");
    }

    public function user() {
        return $this->hasOne("User", "id", "user_id");
    }
    
    public function tags() {
        return $this->belongsToMany("Tag", "posts_tags", "post_id", "tag_id");
    }

    public function categories() {
        return $this->belongsToMany("Category", "posts_categories", "post_id", "category_id");
    }

    /*
    function setRawAttributes(array $attributes, $sync = false)
    {

        foreach($attributes as $name => $value){
            if($name = "created_at"){

                $attributes["created_at"] = "";
            }
        }

        $this->attributes = $attributes;

        return $this;

    }
    */

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
                    $tag->name = $tag_name;
                    $tag->save();
                    $tag_ids[] = $tag->id;
                }
            }
        }
        $this->tags()->sync($tag_ids);
    }

}
