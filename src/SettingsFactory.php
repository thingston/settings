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
     * @param string $file
     * @return SettingsInterface
     * @throws InvalidArgumentException
     */
    public static function fromFile(string $file): SettingsInterface
    {
        if (false === file_exists($file)) {
            throw InvalidArgumentException::forFileNotFound($file);
        }

        $settings = include $file;

        if (false === is_array($settings)) {
            throw InvalidArgumentException::forFileContents($file, gettype($settings));
        }

        return new Settings($settings);
    }
}
