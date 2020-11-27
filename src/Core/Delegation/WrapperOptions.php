<?php

declare(strict_types=1);

namespace WJS\Mutagen\Core\Delegation;

use WJS\Mutagen\Core\Reflection\Classname;

/**
 * @package WJS\Mutagen\Core\Delegation
 */
final class WrapperOptions
{
    /**
     * @var Classname
     */
    private $className;

    /**
     * @var Classname
     */
    private $parentName;

    /**
     * @var Delegate
     */
    private $methodDelegate;

    /**
     * @param Classname $className
     * @param Classname $parentName
     * @param Delegate $methodDelegate
     */
    public function __construct(
        Classname $className,
        Classname $parentName,
        Delegate $methodDelegate
    ) {
        $this->className = $className;
        $this->parentName = $parentName;
        $this->methodDelegate = $methodDelegate;
    }

    /**
     * @return Classname
     */
    public function getClass(): Classname
    {
        return $this->className;
    }

    /**
     * @param Classname $className
     * @return WrapperOptions
     */
    public function setClassName(Classname $className): WrapperOptions
    {
        $this->className = $className;

        return $this;
    }

    /**
     * @return Classname
     */
    public function getParent(): Classname
    {
        return $this->parentName;
    }

    /**
     * @param Classname $parentName
     * @return WrapperOptions
     */
    public function setParentName(Classname $parentName): WrapperOptions
    {
        $this->parentName = $parentName;

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
     * @return WrapperOptions
     */
    public function setMethodDelegate(Delegate $methodDelegate): WrapperOptions
    {
        $this->methodDelegate = $methodDelegate;

        return $this;
    }
}
