<?php

/**
 * Class Category
 */
class Category extends Dot\Model
{

    /**
     * @var string
     */
    protected $module = 'categories';

    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string
     */
    protected $parentKey = 'parent';

    /**
     * @var array
     */
    protected $fillable = array('*');

    /**
     * @var array
     */
    protected $guarded = array('id');

    /**
     * @var array
     */
    protected $visible = array();

    /**
     * @var array
     */
    protected $hidden = array();

    /**
     * @var array
     */
    protected $searchable = ['name', 'slug'];

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
        "name" => "required",
        "slug" => "unique:categories,slug"
    ];

    /**
     * @var array
     */
    protected $updatingRules = [
        "name" => "required",
        "slug" => "required|unique:categories,slug,[id],id"
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    function image()
    {
        return $this->hasOne("Media", "id", "image_id");
    }

    /**
     * @param $query
     * @param int $parent
     */
    function scopeParent($query, $parent = 0)
    {
        $query->where("categories.parent", $parent);
    }

    /**
     * @param array $options
     */
    function save(array $options = array())
    {
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

    /**
     * @param int $parent
     * @return array
     */
    public static function map($parent = 0)
    {

        $row = Category::where("categories.id", $parent)->first();

        static $new_cats = array();

        if (count($row)) {
            $new_cats[] = $row;
            self::map($row->parent);
        }

        return array_reverse($new_cats);
    }

    /**
     * @param $db
     * @return mixed
     */
    public static function getCategories($db)
    {
        return $categories = DB::table('categories')
            ->where('categories.site', '=', $db)
            ->get();
    }

    /**
     * @param $conn
     * @param int $parent_id
     * @param string $key
     * @param $db
     * @return mixed
     */
    public static function getChildCategories($conn, $parent_id = 0, $key = "", $db)
    {
        $lang = Lang::getLocale();
        $categories = DB::table('categories')->where("parent", "=", $parent_id)
            ->leftJoin("media", "media.id", "=", "categories.image_id")
            ->where('categories.site', '=', $db);
        if ($key != "") {
            $categories->where("name", "LIKE", '%' . $key . '%');
        }
        return $categories->paginate(20);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getcategory($id)
    {
        return $category = DB::table('categories')
            ->leftJoin("media", "media.id", "=", "categories.cat_img")
            ->where("categories.id", "=", $id)
            ->get();
    }

    /**
     * @param $id
     * @param $code
     * @return mixed
     */
    public static function getCategoryLangs($id, $code)
    {
        return $langs = DB::table('categories')
            ->where("id", "=", $id)
            ->where("site", "=", $code)
            ->get();
    }

    /**
     * @param $row
     * @return mixed
     */
    public static function saveCategory($row)
    {
        return $id = DB::table('categories')->insertGetId($row);
    }

    /**
     * @param $row
     */
    public static function saveCategorylangs($row)
    {
        DB::table('categories')->insert($row);
    }

    /**
     * @param $row
     * @param $id
     */
    public static function updateCategory($row, $id)
    {
        DB::table('categories')->where('id', $id)->update($row);
    }

    /**
     * @param $row
     * @param $id
     * @param $lang
     */
    public static function updateCategorylangs($row, $id, $lang)
    {
        DB::table('categories')
            ->where('id', $id)
            ->where('site', $lang)
            ->update($row);
    }

    /**
     * @param $id
     */
    public static function deleteCategory($id)
    {
        DB::table('categories')->where('id', '=', $id)->delete();
    }

    /**
     * @return mixed
     */
    public function posts()
    {
        return $this->belongsToMany('Post', 'posts_categories', 'category_id', 'post_id')->select(DB::raw('count(posts_categories.id) as counts'))
            ->groupBy('posts_categories.id')->orderBy('counts', 'desc');
    }

    /**
     * @return mixed
     */
    public function postViews()
    {
        return $this->belongsToMany('Post', 'posts_categories', 'category_id', 'post_id')
            ->leftJoin('posts_stats', 'posts_stats.post_id', '=', 'posts.id')
            ->select(DB::raw('sum(posts_stats.views) as total'))->groupBy('posts.id')->where('type', 'post');
    }

    /**
     * @return mixed
     */
    public function postStats()
    {
        return $this->belongsToMany('PostStat', 'posts_categories', 'category_id', 'post_id')
            ->select(DB::raw('sum(facebook) as facebook'), DB::raw('sum(twitter) as twitter'), DB::raw('sum(youtube) as youtube'))
            ->leftJoin('posts', 'posts.id', '=', 'posts_stats.post_id')->where('type', 'post')->groupBy('posts.id');
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
