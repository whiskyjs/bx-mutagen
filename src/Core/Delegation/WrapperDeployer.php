<?php

declare(strict_types=1);

namespace WJS\Mutagen\Core\Delegation;

/**
 * @package WJS\Mutagen\Core\Delegation
 */
final class WrapperDeployer
{
    /**
     * @param Wrapper $componentWrapper
     */
    public function deployWrapperClass(Wrapper $componentWrapper): void
    {
        $this->evaluateWrapperClass($componentWrapper);

        $this->setupWrapperClass($componentWrapper);
    }

    /**
     * @param Wrapper $componentWrapper
     */
    private function evaluateWrapperClass(Wrapper $componentWrapper): void
    {
        eval($componentWrapper->getCode());
    }

    /**
     * @param Wrapper $componentWrapper
     */
    private function setupWrapperClass(Wrapper $componentWrapper): void
    {
        forward_static_call(
            [(string) $componentWrapper->getClass(), "setMethodDelegate"],
            $componentWrapper->getMethodDelegate()
        );
    }
}
