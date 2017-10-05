<?php

namespace Dot\Platform\Classes;

use Illuminate\Events\Dispatcher;
use Illuminate\View\View;


/**
 * Class DotAction
 * @package Dot\Platform
 */
class Action extends Dispatcher
{

    /**
     * @param $event
     * @param array $payload
     * @param bool $halt
     * @return bool
     */
    public function render($event, $payload = [], $halt = false)
    {

        $output = $this->fire($event, $payload, $halt);

        if ($halt) {
            return true;
        }

        foreach ($output as $value) {

            if ($value instanceof View) {
                echo $value->render();
            } else {
                echo $value;
            }

        }

        return true;
    }

}
