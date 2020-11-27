<?php

declare(strict_types=1);

namespace WJS\Mutagen\BX\Main\Component;

use WJS\Mutagen\Core\Delegation\WrapperBuilder;
use WJS\Mutagen\Core\Delegation\WrapperDeployer;
use WJS\Mutagen\Core\Delegation\WrapperOptions;
use WJS\Mutagen\Core\Reflection\Classname;

/**
 * @package WJS\Mutagen\BX\Main\Component
 */
class ComponentInterceptorAgent extends \ArrayObject
{
    const WRAPPER_PREFIX = "__Intercepted";

    /**
     * @var ComponentInterceptorOptions
     */
    private ComponentInterceptorOptions $options;

    /**
     * @var array
     */
    private array $classCache = [];

    /**
     * @var array
     */
    private array $wrapperCache = [];

    /**
     * @param array $input
     * @param int $flags
     * @param string $iterator_class
     */
    public function __construct($input = array(), $flags = 0, $iterator_class = "ArrayIterator")
    {
        parent::__construct($input, $flags, $iterator_class);

        foreach ($input as $componentPath => $componentClass) {
            $this->classCache[$componentClass] = $this[$componentPath];
        }
    }

    /**
     * @param string $componentPath
     * @return mixed
     * @throws \ReflectionException
     */
    public function offsetGet($componentPath)
    {
        $componentClass = parent::offsetGet($componentPath);

        if (!$componentClass) {
            $this[$componentPath] = $componentClass;
            return $componentClass;
        }

        if (in_array($componentClass, $this->wrapperCache)) {
            return $componentClass;
        }

        $predicate = $this->options->getPredicate();

        if (isset($predicate) && !$predicate($componentClass)) {
            $this[$componentPath] = $componentClass;
            return $componentClass;
        }

        $parentClass = Classname::from($componentClass);
        $wrapperClass = $this->getWrapperClass($parentClass);

        if (!isset($this->classCache[$componentClass])) {
            $reflection = new \ReflectionClass($componentClass);

            if ($reflection->isFinal() || $reflection->isAbstract()) {
                $this->classCache[$componentClass] = $componentClass;
                $this[$componentPath] = $componentClass;
            } else {
                $options = new WrapperOptions(
                    $wrapperClass,
                    $parentClass,
                    $this->options->getMethodDelegate()
                );

                $builder = new WrapperBuilder();
                $wrapper = $builder->buildWrapperComponent($options);
                $evaluator = new WrapperDeployer();
                $evaluator->deployWrapperClass($wrapper);

                $this->classCache[$componentClass] = (string) $wrapperClass;
                $this->wrapperCache[] = (string) $wrapperClass;
                $this[$componentPath] = (string) $wrapperClass;
            }
        }

        return $this->classCache[$componentClass];
    }

    /**
     * @param Classname $class
     * @return Classname
     */
    private function getWrapperClass(Classname $class): Classname
    {
        $result = clone $class;
        $result->setClassName($this->getWrapperPrefix() . $result->getClassName());

        return $result;
    }

    /**
     * @return string
     */
    private function getWrapperPrefix(): string
    {
        return static::WRAPPER_PREFIX;
    }

    /**
     * @return ComponentInterceptorOptions
     */
    public function getOptions(): ComponentInterceptorOptions
    {
        return $this->options;
    }

    /**
     * @param ComponentInterceptorOptions $options
     * @return ComponentInterceptorAgent
     */
    public function setOptions(ComponentInterceptorOptions $options): ComponentInterceptorAgent
    {
        $this->options = $options;

        return $this;
    }
}
