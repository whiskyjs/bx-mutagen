<?php

declare(strict_types=1);

namespace WJS\Mutagen\Core\Delegation;

/**
 * @package WJS\Mutagen\Core\Delegation
 */
final class WrapperBuilder
{
    /**
     * @param WrapperOptions $options
     * @return Wrapper
     */
    public function buildWrapperComponent(WrapperOptions $options): Wrapper
    {
        $code = "";

        if ($namespace = $options->getClass()->getNamespace()) {
            $code .= <<<EOT
            namespace $namespace;
            
            
            EOT;
        }

        $code .= <<<EOT
            class {$options->getClass()->getClassName()} extends {$options->getParent()->setWithSlash()}
            {
                private static \$methodDelegate;
                
                public static function setMethodDelegate(\$methodDelegate)
                {
                    static::\$methodDelegate = \$methodDelegate;
                }
                
                public static function getMethodDelegate()
                {
                    return static::\$methodDelegate;
                }
            
                {$this->getWrapperMethods($options)}
            }
            EOT;

        return new Wrapper((string) $options->getClass(), $code, $options->getMethodDelegate());
    }

    /**
     * @param WrapperOptions $options
     * @return string
     */
    private function getWrapperMethods(WrapperOptions $options): string
    {
        $methodList = $options->getMethodDelegate()->getDelegatedMethods();

        return array_reduce($methodList, function (string $acc, DelegatedMethod $method) {
            return $acc . <<<EOT
                {$this->getVisibility($method)}function {$method->getName()}(...\$args){$this->getReturnType($method)}
                {
                    {$this->getWrapperMethodInvocation($method)}
                }
            EOT;
        }, "");
    }

    /**
     * @param DelegatedMethod $method
     * @return string
     */
    private function getWrapperMethodInvocation(DelegatedMethod $method): string
    {
        $returnType = $method->getReturnType();

        if (!$returnType || in_array($returnType, ["void"])) {
            return "static::\$methodDelegate->{$method->getName()}(...\$args);" . "\n";
        }

        return "return static::\$methodDelegate->{$method->getName()}(...\$args);" . "\n";
    }

    /**
     * @param DelegatedMethod $method
     * @return string
     */
    private function getReturnType(DelegatedMethod $method): string
    {
        if ($method->getReturnType()) {
            return ": " . $method->getReturnType();
        }

        return "";
    }

    /**
     * @param DelegatedMethod $method
     * @return string
     */
    private function getVisibility(DelegatedMethod $method): string
    {
        if ($method->getVisibility()) {
            return $method->getVisibility() . " ";
        }

        return "";
    }
}
