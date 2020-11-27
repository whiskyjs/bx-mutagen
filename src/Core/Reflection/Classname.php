<?php

declare(strict_types=1);

namespace WJS\Mutagen\Core\Reflection;

use function WJS\Mutagen\array_key_last;

/**
 * @package WJS\Mutagen\Core\Reflection
 */
final class Classname
{
    /**
     * @param string $className
     * @return static
     */
    public static function from(string $className): self
    {
        $instance = new self();

        $parts = explode("\\", $className);

        if (!$parts) {
            throw new \InvalidArgumentException("Имя класса не найдено.");
        }

        if (mb_substr($className, 0, 1) === "\\") {
            $instance->setWithSlash(true);
        }

        if (count($parts) > 1) {
            $instance->namespace = array_slice($parts, 0, -1);
        }

        $instance->className = $parts[array_key_last($parts)];

        return $instance;
    }

    /**
     * @var string
     */
    private $className = "";

    /**
     * @var string[]
     */
    private $namespace = [];

    /**
     * @var bool
     */
    private $withSlash = false;

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->__toString();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $result = $this->className;

        if ($this->namespace) {
            $result = join("\\", array_merge($this->namespace, [$result]));
        }

        if ($this->withSlash) {
            $result = "\\" . $result;
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @param string $className
     * @return Classname
     */
    public function setClassName(string $className): Classname
    {
        $this->className = $className;

        return $this;
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return join("\\", $this->namespace);
    }

    /**
     * @param string[]|string $namespace
     * @return Classname
     */
    public function setNamespace($namespace): Classname
    {
        $this->namespace = (array) $namespace;

        return $this;
    }

    /**
     * @return bool
     */
    public function isWithSlash(): bool
    {
        return $this->withSlash;
    }

    /**
     * @param bool $withSlash
     * @return Classname
     */
    public function setWithSlash(bool $withSlash = true): Classname
    {
        $this->withSlash = $withSlash;

        return $this;
    }
}
