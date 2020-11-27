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

if (!function_exists("array_key_last")) {
    /**
     * @param mixed $ary
     * @return mixed
     *
     */
    function array_key_last($ary)
    {
        if (!$ary || !is_array($ary)) {
            return null;
        }

        $keys = array_keys($ary);

        if (!$keys || !is_array($keys)) {
            return null;
        }

        return $keys[count($keys) - 1];
    }
}
