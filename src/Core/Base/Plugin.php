<?php

declare(strict_types=1);

namespace WJS\Mutagen\Core\Base;

use WJS\Mutagen\Core\Contract\Pluggable;

/**
 * @package WJS\Mutagen\Core\Base
 */
abstract class Plugin implements Pluggable
{
    /**
     * @var bool
     */
    private $pluggedIn = false;

    /**
     * @return bool
     */
    public function isPluggedIn(): bool
    {
        return $this->pluggedIn;
    }

    /**
     * @param bool $pluggedIn
     * @return Plugin
     */
    public function setPluggedIn(bool $pluggedIn = true): Plugin
    {
        $this->pluggedIn = $pluggedIn;
        return $this;
    }

    /**
     * @throws \Exception
     */
    public function plugIn(): void
    {
        if ($this->isPluggedIn()) {
            throw new \Exception("Попытка подключить уже используемый плагин.");
        }

        $this->plugInInternal();
    }

    /**
     * @throws \Exception
     */
    public function plugOut(): void
    {
        if (!$this->isPluggedIn()) {
            throw new \Exception("Попытка отключить неиспользуемый плагин.");
        }

        $this->plugOutInternal();
    }

    abstract public function plugInInternal(): void;

    abstract public function plugOutInternal(): void;
}
