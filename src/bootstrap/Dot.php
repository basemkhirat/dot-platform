<?php

namespace Dot;

use \Illuminate\Foundation\Application as Laravel;

/**
 * Class Dot
 * Dotcms super class extends Laravel super App class
 */

class CMS extends Laravel
{

    /**
     * get all system locales
     * @return array
     */
    public function getLocales()
    {
        $locales = [];

        foreach ((array)$this['config']->get("admin.locales") as $code => $locale) {
            $locales[$code] = [
            "title" => isset($locale["title"]) ? $locale["title"] : $code,
            "direction" => isset($locale["direction"]) ? $locale["direction"] : "ltr"
        ];
    }

        return $locales;
    }


}