<?php

class Nav extends Dot\Model
{

    protected $module = 'navigations';

    protected $table = 'navigations';

    protected $parentKey = "parent";

    /**
     * Creating rules
     * @var array
     */
    protected $creatingRules = [
        "name" => "required"
    ];

    /**
     * Updating rules
     * @var array
     */
    protected $updatingRules = [
        "name" => "required"
    ];


    public function setValidationAttributes()
    {
        return trans("navigations::navigations.attributes");
    }

    public function saveChildren($children = [])
    {

        $parent = $this->id;

        $order = 0;
        foreach ($children as $item) {

            if (isset($item->id)) {

                $nav = new self();
                $nav->name = $item->name;
                $nav->link = $item->link;
                $nav->type = $item->type;
                $nav->image_id = isset($item->image_id) ? $item->image_id : 0;
                $nav->type_id = $item->type_id;
                $nav->parent = $this->id;
                $nav->order = $order;
                $nav->menu = $this->menu;
                $nav->lang = LANG;

                $nav->save();

                $children = isset($item->children)?$item->children:[];
                $nav->saveChildren($children);

                $order++;

            }


        }
    }

    public function items()
    {
        return $this->hasMany(\App\Models\Nav::class, 'menu');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new NavScope);
    }

}