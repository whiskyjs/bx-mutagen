<?php

declare(strict_types=1);

namespace WJS\Mutagen\BX\Main\Component;

use WJS\Mutagen\Core\Base\Plugin;
use WJS\Mutagen\Core\Delegation\WrapperOptions;

use function WJS\Mutagen\invoke_internal;

/**
 * @package WJS\Mutagen\BX\Main\Component
 */
class ComponentInterceptorPlugin extends Plugin
{
    /**
     * @var ComponentInterceptorOptions
     */
    private ComponentInterceptorOptions $options;

    /**
     * @var ComponentInterceptorAgent|null
     */
    private ?ComponentInterceptorAgent $agent;

    /**
     * @param ComponentInterceptorOptions $options
     */
    public function __construct(ComponentInterceptorOptions $options)
    {
        $this->options = $options;
    }

    /**
     * @throws \Exception
     */
    public function plugInInternal(): void
    {
        $self = $this;

        /** @noinspection PhpUndefinedClassInspection */
        /** @phpstan-ignore-next-line */
        invoke_internal(new \CBitrixComponent(), function () use ($self) {
            /** @noinspection PhpUndefinedFieldInspection */
            /** @phpstan-ignore-next-line */
            $agent = new ComponentInterceptorAgent(static::$__classes_map);
            $agent->setOptions($self->getOptions());
            /** @noinspection PhpUndefinedFieldInspection */
            /** @phpstan-ignore-next-line */
            static::$__classes_map = $agent;
            $self->setAgent($agent);
        });

        $this->setPluggedIn();
    }

    /**
     * @throws \Exception
     */
    public function plugOutInternal(): void
    {
        $self = $this;

        /** @noinspection PhpUndefinedClassInspection */
        /** @phpstan-ignore-next-line */
        invoke_internal(new \CBitrixComponent(), function () use ($self) {
            /** @noinspection PhpUndefinedFieldInspection */
            /** @phpstan-ignore-next-line */
            static::$__classes_map = $self->getAgent()->getArrayCopy();
            $self->setAgent(null);
        });

        $this->setPluggedIn(false);
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
     * @return ComponentInterceptorPlugin
     */
    public function setOptions(WrapperOptions $options): ComponentInterceptorPlugin
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return ComponentInterceptorAgent|null
     */
    public function getAgent(): ?ComponentInterceptorAgent
    {
        return $this->agent;
    }

    /**
     * @param ComponentInterceptorAgent|null $agent
     * @return ComponentInterceptorPlugin
     */
    public function setAgent(?ComponentInterceptorAgent $agent): ComponentInterceptorPlugin
    {
        $this->agent = $agent;

        return $this;
    }
}
