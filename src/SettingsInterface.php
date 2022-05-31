<?php

declare(strict_types=1);

namespace Thingston\Settings;

use Psr\Container\ContainerInterface;

interface SettingsInterface extends ContainerInterface
{
    /**
     * @return array<mixed>
     */
    public function toArray(): array;
}
