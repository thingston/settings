<?php

declare(strict_types=1);

namespace Thingston\Settings;

use Psr\Container\ContainerInterface;

interface SettingsInterface extends ContainerInterface
{
    /**
     * @return array<string, array<mixed>|scalar|SettingsInterface>
     */
    public function toArray(): array;
}
