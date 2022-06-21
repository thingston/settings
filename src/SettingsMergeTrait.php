<?php

declare(strict_types=1);

namespace Thingston\Settings;

trait SettingsMergeTrait
{
    /**
     * @param SettingsInterface|array<string, array<mixed>|scalar|SettingsInterface> $settings1
     * @param SettingsInterface|array<string, array<mixed>|scalar|SettingsInterface> $settings2
     * @return SettingsInterface
     */
    public static function merge(
        SettingsInterface|array $settings1,
        SettingsInterface|array $settings2
    ): SettingsInterface {
        if ($settings1 instanceof SettingsInterface) {
            $settings1 = $settings1->toArray();
        }

        if ($settings2 instanceof SettingsInterface) {
            $settings2 = $settings2->toArray();
        }

        foreach ($settings2 as $key => $value) {
            if (
                $value instanceof SettingsInterface
                && isset($settings1[$key])
                && $settings1[$key] instanceof SettingsInterface
            ) {
                $settings1[$key] = self::merge($settings1[$key], $value);
                continue;
            }

            if (is_array($value) && isset($settings1[$key]) && is_array($settings1[$key])) {
                $settings1[$key] = array_merge($settings1[$key], $value);
                continue;
            }

            $settings1[$key] = $value;
        }

        return new Settings($settings1);
    }
}
