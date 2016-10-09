<?php

use Carbon\Carbon;

class Post extends Dot\Model
{

    protected $module = 'posts';

    protected $table = 'posts';
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

    public function scopeFormat($query, $format)
    {
        $query->where("format", $format);
    }

    public function meta()
    {
        return $this->hasMany("PostMeta");
    }

    public function image()
    {
        return $this->hasOne("Media", "id", "image_id");
    }

    public function media()
    {
        return $this->hasOne("Media", "id", "media_id");
    }

    public function user()
    {
        return $this->hasOne("User", "id", "user_id");
    }

    public function tags()
    {
        return $this->belongsToMany("Tag", "posts_tags", "post_id", "tag_id");
    }

    public function blocks()
    {
        return $this->belongsToMany("Block", "posts_blocks", "post_id", "block_id");
    }

    public function categories()
    {
        return $this->belongsToMany("Category", "posts_categories", "post_id", "category_id");
    }

    public function syncTags($tags)
    {
        $tag_ids = array();

        if ($tags = @explode(",", $tags)) {
            $tags = array_filter($tags);
            $tag_ids = Tag::saveNames($tags);
        }

        $this->tags()->sync($tag_ids);
    }

    function syncBlocks($blks){

        $blocks = Block::with("posts")->get();

        foreach ($blocks as $block) {

            $post_ids = $block->posts->pluck("id");

            if (!$post_ids->has($this->id)) {
                $post_ids->prepend($this->id);
            }

            $post_ids = $post_ids->unique()->toArray();

            $sync = [];

            $i = 0;
            foreach($post_ids as $post_id){
                $sync[$post_id] = ['order' => $i];
                $i++;
            }

            $block->posts()->sync($sync);

        }

        DB::table("posts_blocks")->where("post_id", $this->id)->whereNotIn("block_id", $blks)->delete();

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
