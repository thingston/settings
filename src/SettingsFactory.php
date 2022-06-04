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

    /**
     * @param string $path
     * @param bool $recursive
     * @return SettingsInterface
     * @throws InvalidArgumentException
     */
    public static function fromDir(string $path, bool $recursive = false): SettingsInterface
    {
        if (false === is_dir($path) || false === $scan = scandir($path)) {
            throw InvalidArgumentException::forInvalidDirectory($path);
        }

        $settings = [];

        foreach ($scan as $entry) {
            $file = $path . DIRECTORY_SEPARATOR . $entry;

            if (is_file($file) && '.php' === substr($file, -4)) {
                $settings[substr($entry, 0, -4)] = self::fromFile($file);
            }
        }

        if ($recursive) {
            foreach ($scan as $entry) {
                $file = $path . DIRECTORY_SEPARATOR . $entry;

                if (false === in_array($entry, ['.', '..']) && is_dir($file)) {
                    $settings = Settings::merge($settings, self::fromDir($file, true))->toArray();
                }
            }
        }

        return new Settings($settings);
    }
}
