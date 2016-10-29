<?php

use Illuminate\Database\Eloquent\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PollScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        return $builder->where('lang', LANG);
    }
}