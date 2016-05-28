<?php

namespace Dot;

use Illuminate\Console\Scheduling\Schedule as Schedular;


class Schedule
{

    public static function run($callback = false)
    {

        app()->booted(function () use ($callback) {

            $schedule = app()->make(Schedular::class);

            if (is_callable($callback)) {
                return $callback($schedule);
            }

        });


    }

}