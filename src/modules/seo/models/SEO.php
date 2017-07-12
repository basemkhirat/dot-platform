<?php

use Illuminate\Database\Eloquent\Model;

class SEO extends Model {

    protected $table = 'seo';

    protected $fillable = [];

    protected $guarded = ['id'];

    public $timestamps = false;

    public function post() {
        return $this->belongsTo('Post', 'post_id');
    }

    public function page() {
        return $this->belongsTo('Page', 'post_id');
    }

    public function facebook() {
        return $this->hasOne('Media', 'id', 'facebook_image');
    }

    public function twitter() {
        return $this->hasOne('Media', 'id', 'twitter_image');
    }

}
