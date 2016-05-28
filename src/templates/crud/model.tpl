<?php

class #model|ucfirst# extends Model {


    protected $module = '#module#';
    
    protected $table = '#module#';
    protected $primaryKey = '#key#';
    
    public $timestamps = #options.timestamps#;
    
    protected $fillable = array('*');
    protected $guarded = array('#key#');
    
    protected $visible = array('*');
    protected $hidden = array();
    
    protected $searchable = [#searchable#];
    protected $perPage = #options.per_page#;
    
    protected $sluggable = [
        #sluggable#
    ];
    
    protected $creatingRules = [
        
    ];
    
    protected $updatingRules = [
        
    ];
    
    #relation_functions#
    
    {if module.image}
    public function image() {
        return $this->hasOne("Media", "media_id", "image_id");
    }
    {/if}
    
    {if module.user}
    public function user(){
        return $this->hasOne("User", "id", "user_id");
    }
    {/if}
    
    {if module.categories}
    public function categories() {
        return $this->belongsToMany("Category", "#module#_categories", "#model#_id", "category_id");
    }

    public function syncCategories($categories) {
        $this->categories()->sync((array) $categories);
    }
    {/if}
    
    {if module.tags}
    public function tags() {
        return $this->belongsToMany("Tag", "#module#_tags", "#model#_id", "tag_id");
    }

    public function syncTags($tags) {

        $tag_ids = array();
        $tags = @array_filter(explode(",", $tags));
        if (count($tags)) {
            $tags = array_filter($tags);
            foreach ($tags as $name) {
                $tag = Tag::select("id")->where("name", $name)->first();
                if (count($tag)) {
                    // tag exists
                    $tag_ids[] = $tag->id;
                } else {
                    // create new tag
                    $tag = new Tag();
                    $tag->name = $name;
                    $tag->slug = Str::slug($name);
                    $tag->save();

                    $tag_ids[] = $tag->id;
                }
            }
        }

        $this->tags()->sync($tag_ids);
    }
    {/if}
}