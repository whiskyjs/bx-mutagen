<?php

declare(strict_types=1);

namespace WJS\Mutagen\BX\Main\Component;

use WJS\Mutagen\Core\Delegation\Delegate;

/**
 * @package WJS\Mutagen\BX\Main\Component
 */
class ComponentInterceptorOptions
{
    /**
     * @var Delegate
     */
    private $methodDelegate;

    /**
     * @var \Closure|null
     */
    private $predicate;

    /**
     * @param Delegate $methodDelegate
     * @param \Closure|null $predicate
     */
    public function __construct(Delegate $methodDelegate, ?\Closure $predicate = null)
    {
        $this->methodDelegate = $methodDelegate;
        $this->predicate = $predicate;
    }

    /**
     * @return Delegate
     */
    public function getMethodDelegate(): Delegate
    {
        return $this->methodDelegate;
    }

    /**
     * @param Delegate $methodDelegate
     * @return ComponentInterceptorOptions
     */
    public function setMethodDelegate(Delegate $methodDelegate): ComponentInterceptorOptions
    {
        $this->methodDelegate = $methodDelegate;

        return $this;
    }

    /**
     * @return \Closure|null
     */
    public function getPredicate(): ?\Closure
    {
        return $this->predicate;
    }

    /**
     * @param \Closure $predicate
     * @return ComponentInterceptorOptions
     */
    public function setPredicate(\Closure $predicate): ComponentInterceptorOptions
    {
        $this->predicate = $predicate;

        return $this;
    }
}
