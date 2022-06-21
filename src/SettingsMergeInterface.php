<?php

declare(strict_types=1);

namespace Thingston\Settings;

interface SettingsMergeInterface
{
    /**
     * @param SettingsInterface|array<string, array<mixed>|scalar|SettingsInterface> $settings1
     * @param SettingsInterface|array<string, array<mixed>|scalar|SettingsInterface> $settings2
     * @return SettingsInterface
     */
    public static function merge(
        SettingsInterface|array $settings1,
        SettingsInterface|array $settings2
    ): SettingsInterface;
}
