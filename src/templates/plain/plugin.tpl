<?php

/**
 * Class #module|ucfirst#Provider
 */
class #module|ucfirst#Provider extends Plugin
{

    /**
     * Plugin details
     * @return array
     */
    function info(){

        return [
            'name' => '#module#',
            'description' => '',
            'version' => '0.1',
            'icon' => 'fa-puzzle-piece',
            'author' => '',
            'url' => ''
        ];

    }

    /**
     * Plugin bootstrap
     * Called in system boot
     */
    function boot(){

    }

    /**
     * Plugin install
     * Running plugin migrations and default options
     */
    function install(){
        parent::install();
    }

    /**
    * Plugin uninstall
    * Rollback plugin installation
    */
    function uninstall(){
        parent::uninstall();
    }

}