<?php

declare(strict_types=1);

namespace WJS\Mutagen\Core\Contract;

/**
 * @package WJS\Mutagen\Core\Contract
 */
interface Pluggable
{
    public function plugIn(): void;

    public function plugOut(): void;

    public function isPluggedIn(): bool;
}
