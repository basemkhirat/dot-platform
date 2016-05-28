<?php

class Option extends Model
{

    protected $module = 'options';
    protected $table = 'options';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = array('*');
    protected $guarded = array('ID');
    protected $visible = array('*');
    protected $hidden = array();
    protected $perPage = 15;
    protected $sluggable = [
    ];
    protected $creatingRules = [
    ];
    protected $updatingRules = [
    ];
    protected $pages = [];

    public static function store($options = array(), $module = "")
    {

        $attributes = array();

        foreach ($options as $name => $value) {
            if (strpos($name, 'app_') === 0) {
                $attributes[str_replace("app_", "app.", $name)] = $value;
            } elseif (strpos($name, 's3_') === 0) {
                $attributes[str_replace("s3_", "s3.", $name)] = $value;
            } else {
                $attributes[$name] = $value;
            }
        }

        foreach ($attributes as $name => $value) {

            if($module != ""){
                $name = $module.".".$name;
            }

            if (Option::where("name", $name)->count()) {
                Option::where("name", $name)->update(array(
                    "value" => $value,
                ));
            } else {
                Option::insert(array(
                    "name" => $name,
                    "value" => $value
                ));
            }
        }
    }

}
