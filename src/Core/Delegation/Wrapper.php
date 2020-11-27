<?php

declare(strict_types=1);

namespace WJS\Mutagen\Core\Delegation;

/**
 * @package WJS\Mutagen\Core\Delegation
 */
final class Wrapper
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var string
     */
    private $code;

    /**
     * @var Delegate
     */
    private $methodDelegate;

    /**
     * @param string $class
     * @param string $code
     * @param Delegate $methodDelegate
     */
    public function __construct(string $class, string $code, Delegate $methodDelegate)
    {
        $this->class = $class;
        $this->code = $code;
        $this->methodDelegate = $methodDelegate;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     * @return Wrapper
     */
    public function setClass(string $class): Wrapper
    {
        $this->class = $class;

        return $this;
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
     * @return Wrapper
     */
    public function setMethodDelegate(Delegate $methodDelegate): Wrapper
    {
        $this->methodDelegate = $methodDelegate;

        return $this;
    }
}
