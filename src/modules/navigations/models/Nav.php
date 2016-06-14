<?php

class Nav extends Model
{

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
                $nav->type = $item->type;
                $nav->type_id = $item->type_id;
                $nav->parent = $this->id;
                $nav->order = $order;
                $nav->menu = $this->menu;

                $nav->save();

                $children = isset($item->children)?$item->children:[];
                $nav->saveChildren($children);

                $order++;

            }


        }
    }

}