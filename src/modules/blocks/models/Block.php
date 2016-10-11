<?php

/**
 * Class Block
 */
class Block extends Dot\Model
{
    /**
     * @var string
     */
    protected $module = "blocks";

    /**
     * @var string
     */
    protected $table = "blocks";

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
     * @var bool
     */
    public $timestamps = false;

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
        "name" => "required",
        "limit" => "required|numeric"
    ];

    /**
     * @var array
     */
    protected $updatingRules = [
        "name" => "required",
        "limit" => "required|numeric"
    ];

    /**
     * @param $v
     * @return mixed
     */
    function setValidation($v)
    {
        $v->setCustomMessages((array)trans('blocks::validation'));
        $v->setAttributeNames((array)trans("blocks::blocks.attributes"));
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
     * @param $tags
     */
    public function syncTags($tags)
    {
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany("Tag", "blocks_tags", "block_id", "tag_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany("Category", "blocks_categories", "block_id", "category_id");
    }

    /**
     * @return mixed
     */
    public function posts()
    {
        return $this->belongsToMany("Post", "posts_blocks", "block_id", "post_id")->orderBy('order')->withPivot('order');;
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

    /**
     * Add post to block
     * @param $post
     * @return bool
     */
    public function addPost($post)
    {

        if (!is_object($post) || count($post) == 0) {
            return false;
        }

        $posts_ids = $this->posts->pluck("id");

        if (!in_array($post->id, $posts_ids->toArray())) {

            $posts_ids->prepend($post->id)->splice($this->limit);

            $sync = [];
            $i = 0;

            foreach ($posts_ids as $post_id) {
                $sync[$post_id] = ['order' => $i];
                $i++;
            }

            $this->posts()->sync($sync);
        }

    }

    /**
     * Remove post from block
     * @param $post
     * @return bool
     */
    public function removePost($post)
    {

        if (!is_object($post) || count($post) == 0) {
            return false;
        }

        $this->posts()->detach($post->id);

    }

}