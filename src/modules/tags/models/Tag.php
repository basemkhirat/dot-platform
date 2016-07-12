<?php

class Tag extends Dot\Model
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
        "name" => "required"
    ];

    protected $updatingRules = [
        "name" => "required"
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