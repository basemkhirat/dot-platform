<?php

use Illuminate\Database\Eloquent\Model as BaseModel;
use Carbon\Carbon;

/**
 * Class Model
 */
class Model extends BaseModel
{
    use ModelTraits {
        ModelTraits::__construct as private traitConstructor;
    }
}

/**
 * Class ModelTraits
 */
trait ModelTraits
{
    /**
     * Error message bag
     *
     * @var Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $creatingRules = [];
    /**
     * @var array
     */
    protected $updatingRules = [];
    /**
     * @var array
     */
    protected $searchable = [];

    /**
     * @var array
     */
    protected $sluggable = [];


    /**
     * @var array
     */
    private $pendingMessages = [];


    /**
     * @var array
     */
    private $pendingAttributes = [];

    /**
     * @var array
     */
    protected $params = [];

    /**
     * Validator instance
     *
     * @var Illuminate\Validation\Validators
     */
    public $validator;

    /**
     * ModelTraits constructor.
     * @param array $attributes
     * @param Validator|null $validator
     */
    public function __construct(array $attributes = array(), Validator $validator = null)
    {
        $this->params = $attributes;
        parent::__construct($attributes);
        $this->validator = $validator ?: \App::make('validator');
    }

    /**
     * @param $query
     * @param $q
     */
    public function scopeSearch($query, $q)
    {
        $query->where(function ($where_ob) use ($q) {
            $i = 0;
            foreach ($this->searchable as $field) {
                if ($i == 0) {
                    $where_ob->where($field, 'LIKE', '%' . $q . '%');
                } else {
                    $where_ob->orWhere($field, 'LIKE', '%' . $q . '%');
                }
                $i++;
            }
        });
    }


    /**
     * Return a timestamp as DateTime object.
     *
     * @param  mixed  $value
     * @return \Carbon\Carbon
     */
    protected function asDateTime($value)
    {

        // If this value is already a Carbon instance, we shall just return it as is.
        // This prevents us having to re-instantiate a Carbon instance when we know
        // it already is one, which wouldn't be fulfilled by the DateTime check.
        if ($value instanceof DotCarbon) {
            return $value;
        }

        // If the value is already a DateTime instance, we will just skip the rest of
        // these checks since they will be a waste of time, and hinder performance
        // when checking the field. We will just return the DateTime right away.
        if ($value instanceof DateTimeInterface) {
            return new Carbon(
                $value->format('Y-m-d H:i:s.u'), $value->getTimeZone()
            );
        }

        // If this value is an integer, we will assume it is a UNIX timestamp's value
        // and format a Carbon object from this timestamp. This allows flexibility
        // when defining your date fields as they might be UNIX timestamps here.
        if (is_numeric($value)) {
            return DotCarbon::createFromTimestamp($value);
        }

        // If the value is in simply year, month, day format, we will instantiate the
        // Carbon instances from that format. Again, this provides for simple date
        // fields on the database, while still supporting Carbonized conversion.
        if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $value)) {
            return DotCarbon::createFromFormat('Y-m-d', $value)->startOfDay();
        }

        // Finally, we will just assume this date is in the format used by default on
        // the database connection and use that format to create the Carbon object
        // that is returned back out to the developers after we convert it here.
        return DotCarbon::createFromFormat($this->getDateFormat(), $value);
    }

    /**
     * @param $slug
     * @param $to
     * @param int $index
     * @return string
     */
    public function slugify($slug, $to, $index = 1)
    {

        if ($index == 1) {
            $sluggy = $slug;
        } else {
            $sluggy = $slug . "-" . $index;
        }

        if (DB::table($this->table)->where($to, $sluggy)->count() > 0) {
            $index = $index + 1;
            return $this->slugify($slug, $to, $index);
        }

        return $sluggy;
    }

    /**
     * @param array $options
     * @return mixed
     */
    public function save(array $options = array())
    {

        if (count($this->sluggable)) {
            if (!$this->exists) {
                // on create we will create slug
                foreach ($this->sluggable as $to => $from) {

                    if (array_key_exists($to, $this->attributes) and $this->attributes[$to] != "") {
                        $unique_slug = $this->attributes[$to];
                    } else if (array_key_exists($from, $this->attributes)) {
                        // create unique slug from a given field value
                        $slug = str_slug_utf8($this->attributes[$from]);
                        $unique_slug = $this->slugify($slug, $to);
                    }

                    $this->attributes[$to] = $unique_slug;
                }
            } else {
                // on update
                foreach ($this->sluggable as $to => $from) {
                    if (array_key_exists($to, $this->attributes)) {
                        //$this->attributes[$to] = $this->attributes;
                        //unset($this->attributes[$to]);
                    }
                }
            }
        }

        return parent::save($options);
    }

    /**
     * @param $key
     * @param $value
     */
    public function setAttribute($key, $value)
    {
        $this->params[$key] = $value;
        parent::setAttribute($key, $value);
    }

    /**
     * @param array $attributes
     */
    public function fill(array $attributes)
    {
        $this->params = $attributes;
        parent::fill($attributes);
    }


    /**
     * @return array
     */
    protected function setValidationMessages()
    {
        return (array)trans('admin::validation');
    }

    /**
     * @return array
     */
    protected function setValidationAttributes()
    {
        return (array)trans($this->module . '::' . $this->module . ".attributes");
    }


    /**
     * @param bool $callback
     */
    public static function validating($callback = false)
    {
        if (is_callable($callback)) {
            Event::listen(get_called_class() . ".validating", $callback);
        }
    }


    /**
     * @param array $rules
     * @param array $messages
     * @param array $attributes
     * @return bool
     */
    public function rules($rules = [], $messages = [], $attributes = [])
    {

        if(count($rules) == 0){
            return false;
        }

        foreach ($rules as $input => $rule) {
            $this->creatingRules[$input] = $rule;
            $this->updatingRules[$input] = $rule;
        }

        $this->pendingMessages = array_merge($this->pendingMessages, $messages);
        $this->pendingAttributes = array_merge($this->pendingAttributes, $attributes);
    }


    /**
     * Validates current attributes against rules
     */
    public function validate()
    {
        if ($this->exists) {

            //update
            $rules = array();
            foreach ($this->updatingRules as $input => $rule) {
                foreach ($this->attributes as $field => $attribute) {

                    if (is_object($this->attributes[$field]) or is_array($this->attributes[$field])) {
                        continue;
                    }

                    if (is_numeric($this->attributes[$field])) {
                        $this->attributes[$field] = (int)$this->attributes[$field];
                    }

                    $rule = str_replace("[" . $field . "]", $this->attributes[$field], $rule);
                    $rules[$input] = $rule;
                }
            }
        } else {
            $rules = $this->creatingRules;
        }

        $messages = array_merge((array)trans('admin::validation'), $this->setValidationMessages());
        $messages = array_merge($messages, $this->pendingMessages);
        $attributes = $this->setValidationAttributes();
        $attributes = array_merge($attributes, $this->pendingAttributes);

        $v = $this->validator->make($this->params, $rules, $messages, $attributes);

        // getting custom validation
        if (method_exists($this, 'setValidation')) {
            $this->setValidation($v);
        }

        if ($this->exists) {
            if (method_exists($this, 'setUpdateValidation')) {
                $this->setUpdateValidation($v);
            }
        } else {
            if (method_exists($this, 'setCreateValidation')) {
                $this->setCreateValidation($v);
            }
        }

        Event::fire(get_called_class() . ".validating", $v);

        if ($v->passes()) {
            return true;
        }

        $this->setErrors($v->messages());
        return false;
    }

    /**
     * Set error message bag
     *
     * @var Illuminate\Support\MessageBag
     */
    protected
    function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Retrieve error message bag
     */
    public
    function errors()
    {
        return $this->errors;
    }

    /**
     * Inverse of wasSaved
     */
    public
    function hasErrors()
    {
        return !empty($this->errors);
    }

    /**
     * @param $query
     * @param array $options
     * @return string
     */
    public
    function scopeTree($query, $options = array())
    {

        static $template = " ";
        static $index = 0;

        if (!isset($options['table'])) {
            $options['table'] = $this->table;
        }
        if (!isset($options['id'])) {
            $options['id'] = $this->primaryKey;
        }
        if (!isset($options['parent'])) {
            $options['parent'] = $this->parentKey;
        }
        if (!isset($options['start'])) {
            $options['start'] = 0;
        }

        if (!isset($options['row'])) {
            $options['row'] = false;
        }

        if (!isset($options['query'])) {
            $options['query'] = false;
        }

        if (!isset($options['depth'])) {
            $options['depth'] = "0";
        }

        if (!isset($options['count'])) {
            $options['count'] = 0;
        }

        $rows = DB::table($options['table']);

        if ($options['query']) {
            $rows = call_user_func($options['query'], $rows);
        }

        $rows = $rows->where($options['parent'], $options['start'])->get();

        if (count($rows)) {

            $options['count']++;
            if ($options['count'] >= 2) {
                $template .= "<ul>";
            }
            foreach ($rows as $row) {
                $index++;

                if ($options['row']) {

                    $list_row = call_user_func($options['row'], $row, $options['count']);

                    if (isset($options['callback'])) {
                        $list_row = call_user_func($options['callback'], $row, $list_row);
                    }

                    $template .= $list_row;
                }

                if ($options['depth'] == $options['count']) {

                    continue;

                } else {

                    $options["start"] = $row->$options['id'];
                    self::tree($options);
                }
            }

            if ($options['count'] >= 2) {
                $template .= "</ul>";
            }
        } else {
            $options['count']--;
        }


        return $template;
    }

}
