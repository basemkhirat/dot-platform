<?php

use Illuminate\Database\Eloquent\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LangScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {

        $lang = false;

        if(GUARD == "api"){
            $lang = Auth::guard("api")->user()->lang;
        }elseif(defined("LANG")){
            $lang = LANG;
        }

        if($lang){
            return $builder->where('posts.lang', $lang)->where("posts.status", 1);
        }

        return $builder->where('posts.lang', $lang);
    }
}