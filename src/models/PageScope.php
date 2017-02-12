<?php

use Illuminate\Database\Eloquent\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PageScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if(GUARD == "api"){
            $lang = Auth::guard("api")->user()->lang;
        }else{
            $lang = app()->getLocale();
        }

        return $builder->where('pages.lang', $lang);
    }
}