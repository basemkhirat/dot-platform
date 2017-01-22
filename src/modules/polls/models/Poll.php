<?php

class Poll extends Dot\Model
{

    protected $module = 'polls';

    protected $table = 'polls';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = ["status"];

    protected $searchable = ['title', 'slug', 'lang'];
    protected $perPage = 10;

    protected $sluggable = [
        "slug" => "title"
    ];

    protected $creatingRules = [
        "title" => "required"
    ];

    protected $updatingRules = [
        "title" => "required"
    ];

    public function parent()
    {
        return $this->belongsTo('Poll', 'parent');
    }

    public function answers()
    {
        return $this->hasMany('Poll', 'parent');
    }

    public function image()
    {
        return $this->hasOne("Media", "id", "image_id");
    }

    public function user()
    {
        return $this->hasOne("User", "id", "user_id");
    }

    public function tags()
    {
        return $this->belongsToMany("Tag", "polls_tags", "poll_id", "tag_id");
    }

    public function syncTags($tags)
    {
        $tag_ids = array();
        $tags = @array_filter(explode(",", $tags));
        if (count($tags)) {
            $tags = array_filter($tags);
            $tag_ids = Tag::saveNames($tags);
        }
        $this->tags()->sync($tag_ids);
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PollsScope);
    }

    function delete()
    {
        Poll::where("parent", $this->id)->delete();
        return parent::delete();

    }

}
