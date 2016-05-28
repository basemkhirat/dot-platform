<?php

class Tag extends Model
{
    protected $module = "tags";

    protected $table = "tags";

    protected $primaryKey = 'id';

    protected $searchable = ['name'];

    protected $perPage = 20;

    protected $sluggable = [
        'slug' => 'name',
    ];

    protected $creatingRules = [
        "name" => "required|tag_clean|tag_min:2|tag_max:50||tag_unique:name"
    ];

    protected $updatingRules = [
        "name" => "required|tag_clean|tag_min:2|tag_max:50|tag_unique:name,[id],id"
    ];

    function setValidation($v)
    {
        $v->setCustomMessages((array)trans('tags::validation'));
        $v->setAttributeNames((array)trans("tags::tags.attributes"));
        return $v;
    }

    function setCountAttribute($value)
    {
        $this->attributes["count"] = 0;
    }

}