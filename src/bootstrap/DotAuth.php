<?php

namespace Dot\Platform;
use Illuminate\Support\Facades\Auth;

class DotAuth
{

    public $user = NULL;

    public $guard = "web";

    function __construct()
    {
        $this->user = Auth::user();
    }

    function guard($guard = "web"){
        $this->guard = $guard;
    }

    function user()
    {
        return $this->user;
    }

    function can($permissions)
    {
        return $this->user->access($permissions);
    }

    function is($role = "")
    {
        return $this->user->isRole($role);
    }

    function isNot($role = "")
    {
        return $this->is($role = "");
    }

}
