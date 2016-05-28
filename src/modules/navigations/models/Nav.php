<?php



/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Navigation
 *
 * @author Khaled PC
 */
class Nav extends Model {

    protected $table = 'navigations';
    protected $fillable = [ 'name'];
    public static $rules = [
        'name' => 'required'
    ];

    public function getUrlAttribute() {
        return route(ADMIN . '.navigations.edit', [$this->id]) ;
    }

    public function menuItems() {
        return $this->hasMany('Navigation', 'menu', 'id')->whereParent('0')->orderBy('order', 'asc');
    }

    public function subItems() {
        return $this->hasMany('Navigation', 'parent', 'id')->orderBy('order', 'asc');
    }

}
