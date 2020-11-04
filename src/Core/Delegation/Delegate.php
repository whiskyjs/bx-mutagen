<?php

declare(strict_types=1);

namespace WJS\Mutagen\Core\Delegation;

use WJS\Mutagen\Core\Reflection\PHPDoc\Comment;

use function WJS\Mutagen\invoke_internal;

/**
 * @package WJS\Mutagen\Core\Delegation
 */
abstract class Delegate
{
    /**
     * @var DelegatedMethod[]|null
     */
    private ?array $methodCache;

    /**
     * @throws \ReflectionException
     */
    public function __construct()
    {
        $this->compileDelegatedMethods();
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getDelegatedMethods(): array
    {
        return $this->methodCache;
    }

    /**
     * @throws \ReflectionException
     */
    public function compileDelegatedMethods(): void
    {
        if (!isset($this->methodCache)) {
            $this->methodCache = [];

            $methods = get_class_methods(static::class);
            $class = static::class;

            foreach ($methods as $method) {
                $reflectionMethod = new \ReflectionMethod($class, $method);

                if (!$reflectionMethod->isPublic()) {
                    continue;
                }

                $comment = new Comment($reflectionMethod->getDocComment() ?: "");

                if (!$comment->getAnnotation("@bx-delegate")) {
                    continue;
                }

                $this->methodCache[$reflectionMethod->getName()] = new DelegatedMethod(
                    $reflectionMethod->getName(),
                    $this->getMethodVisibility($reflectionMethod),
                    $this->getMethodReturnType($reflectionMethod)
                );
            }
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function isDelegatingMethod(string $name): bool
    {
        return isset($this->methodCache[$name]);
    }

    /**
     * @param \ReflectionMethod $method
     * @return string
     */
    private function getMethodVisibility(\ReflectionMethod $method): string
    {
        $map = [
            256 => "public",
            512 => "protected",
            1024 => "private",
        ];

        $modifiers = $method->getModifiers();

        foreach ($map as $mask => $visibility) {
            if ($mask & $modifiers === $mask) {
                return $visibility;
            }
        }

        return "";
    }

    /**
     * @param \ReflectionMethod $method
     * @return string
     */
    private function getMethodReturnType(\ReflectionMethod $method): string
    {
        $returnType = $method->getReturnType();

        if (!$returnType) {
            return "";
        }

        return $returnType->getName();
    }
}
