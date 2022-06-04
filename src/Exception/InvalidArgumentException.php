<?php

declare(strict_types=1);

namespace Thingston\Settings\Exception;

use Thingston\Settings\SettingsInterface;

class InvalidArgumentException extends \InvalidArgumentException implements SettingsExceptionsInterface
{
    public static function forInvalidKey(int|string $key): self
    {
        return new self(sprintf('Invalid element key "%s"; it must be a non-empty string.', $key));
    }

    public static function forInvalidValue(int|string $key, string $type): self
    {
        return new self(sprintf(
            'Invalid element value type "%s" for key "%s"; it must be one of "%s".',
            $type,
            $key,
            implode('", "', ['scalar', SettingsInterface::class])
        ));
    }

    public static function forFileNotFound(string $file): self
    {
        return new self(sprintf('File "%s" not found or it isn\'t readable.', $file));
    }

    public static function forFileContents(string $file, string $type): self
    {
        return new self(sprintf('File "%s" must return an array instead of "%s".', $file, $type));
    }

    public static function forInvalidDirectory(string $dir): self
    {
        return new self(sprintf('Argument "%s" isn\'t a directory or it isn\'t readable.', $dir));
    }
}
