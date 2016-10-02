<?php

namespace Dot\Platform;

use Illuminate\Events\Dispatcher;


/**
 * Class DotAction
 * @package Dot\Platform
 */
class DotAction extends Dispatcher
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
           echo $value;
        }

        return true;
    }

}