<?php

class Block extends Dot\Model
{
    protected $module = "blocks";

    protected $table = "blocks";

    protected $primaryKey = 'id';

    protected $searchable = ['name'];

    protected $perPage = 20;

    public $timestamps = false;

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
        $v->setCustomMessages((array)trans('blocks::validation'));
        $v->setAttributeNames((array)trans("blocks::blocks.attributes"));
        return $v;
    }

    function setCountAttribute($value)
    {
        $this->attributes["count"] = 0;
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

    public function tags() {
        return $this->belongsToMany("Tag", "blocks_tags", "block_id", "tag_id");
    }

    public function categories() {
        return $this->belongsToMany("Category", "blocks_categories", "block_id", "category_id");
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LangScope);
    }

}