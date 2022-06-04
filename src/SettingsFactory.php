<?php

declare(strict_types=1);

namespace Thingston\Settings;

use Thingston\Settings\Exception\InvalidArgumentException;

final class SettingsFactory
{
    /**
     * @param array<string, scalar|SettingsInterface> $settings
     * @return SettingsInterface
     */
    public static function create(array $settings): SettingsInterface
    {
        return new Settings($settings);
    }

    /**
     * @param string $path
     * @return SettingsInterface
     * @throws InvalidArgumentException
     */
    public static function fromFile(string $path): SettingsInterface
    {
        if (false === is_readable($path)) {
            throw InvalidArgumentException::forFileNotFound($path);
        }

        $settings = include $path;

        if (false === is_array($settings)) {
            throw InvalidArgumentException::forFileContents($path, gettype($settings));
        }

        return new Settings($settings);
    }
}
