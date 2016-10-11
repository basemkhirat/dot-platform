<?php

use Carbon\Carbon;

/**
 * Class Post
 */
class Post extends Dot\Model
{

    /**
     * @var string
     */
    protected $module = 'posts';

    /**
     * @var string
     */
    protected $table = 'posts';
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var array
     */
    protected $searchable = ['title', 'excerpt', 'content'];

    /**
     * @var int
     */
    protected $perPage = 20;

    /**
     * @var array
     */
    protected $sluggable = [
        'slug' => 'title',
    ];

    /**
     * @var array
     */
    protected $creatingRules = [
        'title' => 'required'
    ];

    /**
     * @var array
     */
    protected $updatingRules = [
        'title' => 'required'
    ];


    /**
     * @param $query
     * @param $status
     */
    public function scopeStatus($query, $status)
    {
        switch ($status) {
            case "published":
                $query->where("status", 1);
                break;

            case "unpublished":
                $query->where("status", 0);
                break;
        }
    }

    /**
     * @param $query
     * @param $format
     */
    public function scopeFormat($query, $format)
    {
        $query->where("format", $format);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meta()
    {
        return $this->hasMany("PostMeta");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function image()
    {
        return $this->hasOne("Media", "id", "image_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function media()
    {
        return $this->hasOne("Media", "id", "media_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne("User", "id", "user_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany("Tag", "posts_tags", "post_id", "tag_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function blocks()
    {
        return $this->belongsToMany("Block", "posts_blocks", "post_id", "block_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany("Category", "posts_categories", "post_id", "category_id");
    }

    /**
     * Sync tags
     * @param $tags
     */
    public function syncTags($tags)
    {
        $tag_ids = array();

        if ($tags = @explode(",", $tags)) {
            $tags = array_filter($tags);
            $tag_ids = Tag::saveNames($tags);
        }

        $this->tags()->sync($tag_ids);
    }

    /**
     * Sync blocks
     * @param $blks
     */
    function syncBlocks($blks)
    {

        $new_blocks = collect($blks);
        $old_blocks = $this->blocks->pluck("id");

        $added = $new_blocks->diff($old_blocks)->toArray();

        foreach (Block::whereIn("id", $added)->get() as $block) {
            $block->addPost($this);
        }

        $removed = $old_blocks->diff($new_blocks)->toArray();

        foreach (Block::whereIn("id", $removed)->get() as $block) {
            $block->removePost($this);
        }

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
