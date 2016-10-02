<?php

/**
 * Class Auth
 * This is an extended class from laravel Auth model
 * to add authentication events
 */
class Auth extends Illuminate\Support\Facades\Auth
{

    /**
     * @param $callback
     * Event after login
     */
    public static function loggingIn($callback)
    {
        if (is_callable($callback)) {
            Event::listen("auth.login", $callback);
        }
    }

    /**
     * @param $callback
     * Event after logout
     */
    public static function loggingOut($callback)
    {
        if (is_callable($callback)) {
            Event::listen("auth.logout", $callback);
        }
    }

    /**
     * @param $callback
     * Event on forget password after mail is sent
     */
    public static function forgetingPassword($callback)
    {
        if (is_callable($callback)) {
            Event::listen("auth.forget", $callback);
        }
    }

    /**
     * @param $callback
     * Event after reset password
     */
    public static function resetingPassword($callback)
    {
        if (is_callable($callback)) {
            Event::listen("auth.reset", $callback);
        }
    }

}