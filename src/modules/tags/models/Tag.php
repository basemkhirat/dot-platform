<?php

/**
 * Class Tag
 */
class Tag extends Dot\Model
{
    /**
     * @var string
     */
    protected $module = "tags";

    /**
     * @var string
     */
    protected $table = "tags";

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $searchable = ['name'];

    /**
     * @var int
     */
    protected $perPage = 20;

    /**
     * @var array
     */
    protected $sluggable = [
        'slug' => 'name',
    ];

    /**
     * @var array
     */
    protected $creatingRules = [
        "name" => "required|unique:tags,name,[id],id"
    ];

    /**
     * @var array
     */
    protected $updatingRules = [
        "name" => "required|unique:tags,name"
    ];

    /**
     * @param $v
     * @return mixed
     */
    function setValidation($v)
    {
        $v->setCustomMessages((array)trans('tags::validation'));
        $v->setAttributeNames((array)trans("tags::tags.attributes"));
        return $v;
    }

    /**
     * @param $value
     */
    function setCountAttribute($value)
    {
        $this->attributes["count"] = 0;
    }


    /**
     * Save multiple tag names
     * @param array $names
     * @return array of tag ids
     */
    public static function saveNames($names = [])
    {

        $tag_ids = [];
        $names = array_unique($names);
        foreach ($names as $name) {
            $tag = self::select("id")->where("name", $name)->first();
            if (count($tag)) {
                // tag exists
                $tag_ids[] = $tag->id;
            } else {
                // create new tag
                $tag = new Tag();
                $tag->name = $name;
                if ($tag->validate()) {
                    $tag->save();
                    $tag_ids[] = $tag->id;
                }
            }

        }

        return $tag_ids;

    }

}