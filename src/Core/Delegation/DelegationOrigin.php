<?php

declare(strict_types=1);

namespace WJS\Mutagen\Core\Delegation;

use function WJS\Mutagen\invoke_internal;

/**
 * @package WJS\Mutagen\Core\Delegation
 */
final class DelegationOrigin
{
    /**
     * @var object
     */
    private object $instance;

    /**
     * @param object $instance
     */
    public function __construct(object $instance)
    {
        $this->instance = $instance;
    }

    /**
     * @return object
     */
    public function getInstance(): object
    {
        return $this->instance;
    }

    /**
     * @param \Closure $fn
     * @return mixed
     */
    public function apply(\Closure $fn)
    {
        return invoke_internal($this->instance, $fn);
    }
}
