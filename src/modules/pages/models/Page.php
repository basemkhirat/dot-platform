<?php

class Page extends Model {

    protected $module = 'pages';

    protected $table = 'pages';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $searchable = ['title', 'excerpt', 'content'];
    protected $perPage = 20;

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

    public function user() {
        return $this->hasOne("User", "id", "user_id");
    }
    
    public function tags() {
        return $this->belongsToMany("Tag", "pages_tags", "page_id", "tag_id");
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
                    $tag->name = $tag_name;
                    $tag->save();
                    $tag_ids[] = $tag->id;
                }
            }
        }
        $this->tags()->sync($tag_ids);
    }

}
