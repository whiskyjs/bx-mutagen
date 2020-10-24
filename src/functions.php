<?php

declare(strict_types=1);

namespace WJS\Mutagen;

/**
 * @param $instance
 * @param \Closure $closure
 * @return mixed
 */
function invoke_internal($instance, \Closure $closure)
{
    return $closure
        ->bindTo($instance, get_class($instance))
        ->call($instance);
}
