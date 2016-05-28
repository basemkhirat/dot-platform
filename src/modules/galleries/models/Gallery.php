<?php

class Gallery extends Model {

    protected $module = 'galleries';

    protected $table = 'galleries';

    protected $primaryKey = 'id';

    protected $fillable = [
        "name",
        "author"
    ];

    protected $sluggable = [
        'slug' => 'name'
    ];

    protected $searchable = [
        "name"
    ];

    protected $creatingRules = [
        "name" => "required"
    ];

    protected $updatingRules = [
        "name" => "required"
    ];


    function files(){
        return $this->belongsToMany("Media", "galleries_media", "gallery_id", "media_id");
    }

}
