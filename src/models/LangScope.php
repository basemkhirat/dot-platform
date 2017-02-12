<?php

use Illuminate\Database\Eloquent\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LangScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {


        if(GUARD == "api"){
            $lang = Auth::guard("api")->user()->lang;
        }else{
            $lang = app()->getLocale();
        }

        if($lang){
            return $builder->where('posts.lang', $lang);
        }

    }
}