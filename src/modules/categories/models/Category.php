<?php

class Category extends Model {

    protected $module = 'categories';
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $parentKey = 'parent';
    public $timestamps = false;
    protected $fillable = array('*');
    protected $guarded = array('id');
    protected $visible = array();
    protected $hidden = array();
    protected $searchable = ['name', 'slug'];
    protected $perPage = 20;
    protected $sluggable = [
        'slug' => 'name',
    ];
    protected $creatingRules = [
        "name" => "required",
        "slug" => "unique:categories,slug"
    ];
    protected $updatingRules = [
        "name" => "required",
        "slug" => "required|unique:categories,slug,[id],id"
    ];

    function image(){
        return $this->hasOne("Media", "id", "image_id");
    }

    function scopeParent($query, $parent = 0) {
        $query->where("categories.parent", $parent);
    }

    function save(array $options = array()) {
        if (parent::save($options)) {
            /*
              // saving translations
              $lang = Request::get("lang");
              CategoryLang::where("lang", $lang)->where("category_id", $this->id)->delete();
              CategoryLang::insert([
              "category_id" => $this->id,
              "lang" => $lang,
              "name" => $this->attributes["name"],
              ]);
             *
             */
        }
    }

    public static function map($parent = 0) {

        $row = Category::where("categories.id", $parent)->first();

        static $new_cats = array();
        if (count($row)) {
            $new_cats[] = $row;
            self::map($row->parent);
        }

        return array_reverse($new_cats);
    }

    public static function getCategories($db) {
        return $categories = DB::table('categories')
                ->where('categories.site', '=', $db)
                ->get();
    }

    public static function getChildCategories($conn, $parent_id = 0, $key = "", $db) {
        $lang = Lang::getLocale();
        $categories = DB::table('categories')->where("parent", "=", $parent_id)
                ->leftJoin("media", "media.id", "=", "categories.image_id")
                ->where('categories.site', '=', $db);
        if ($key != "") {
            $categories->where("name", "LIKE", '%' . $key . '%');
        }
        return $categories->paginate(20);
    }

    public static function getcategory($id) {
        return $category = DB::table('categories')
                ->leftJoin("media", "media.id", "=", "categories.cat_img")
                ->where("categories.id", "=", $id)
                ->get();
    }

    public static function getCategoryLangs($id, $code) {
        return $langs = DB::table('categories')
                ->where("id", "=", $id)
                ->where("site", "=", $code)
                ->get();
    }

    public static function saveCategory($row) {
        return $id = DB::table('categories')->insertGetId($row);
    }

    public static function saveCategorylangs($row) {
        DB::table('categories')->insert($row);
    }

    public static function updateCategory($row, $id) {
        DB::table('categories')->where('id', $id)->update($row);
    }

    public static function updateCategorylangs($row, $id, $lang) {
        DB::table('categories')
                ->where('id', $id)
                ->where('site', $lang)
                ->update($row);
    }

    public static function deleteCategory($id) {
        DB::table('categories')->where('id', '=', $id)->delete();
    }

    public function posts() {
        return $this->belongsToMany('Post', 'posts_categories', 'category_id', 'post_id')->select(DB::raw('count(posts_categories.id) as counts'))
                        ->groupBy('posts_categories.id')->orderBy('counts', 'desc');
    }

    public function postViews() {
        return $this->belongsToMany('Post', 'posts_categories', 'category_id', 'post_id')
                        ->leftJoin('posts_stats', 'posts_stats.post_id', '=', 'posts.id')
                        ->select(DB::raw('sum(posts_stats.views) as total'))->groupBy('posts.id')->where('type', 'post');
    }

    public function postStats() {
        return $this->belongsToMany('PostStat', 'posts_categories', 'category_id', 'post_id')
                        ->select(DB::raw('sum(facebook) as facebook'), DB::raw('sum(twitter) as twitter'), DB::raw('sum(youtube) as youtube'))
                        ->leftJoin('posts', 'posts.id', '=', 'posts_stats.post_id')->where('type', 'post')->groupBy('posts.id');
    }

}
