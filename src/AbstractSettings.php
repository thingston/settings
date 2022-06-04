<?php

declare(strict_types=1);

namespace Thingston\Settings;

use Thingston\Settings\Exception\InvalidArgumentException;

abstract class AbstractSettings implements SettingsInterface
{
    /**
     * @param array<string, array<mixed>|scalar|SettingsInterface> $settings
     */
    public function __construct(private array $settings = [])
    {
        self::assertSettings($settings);

        $this->settings = $settings;
    }

    /**
     * @return array<string, array<mixed>|scalar|SettingsInterface>
     */
    public function __serialize(): array
    {
        return $this->settings;
    }

    /**
     * @param array<string, array<mixed>|scalar|SettingsInterface> $data
     */
    public function __unserialize(array $data): void
    {
        $this->settings = $data;
    }

    /**
     * @return array<string, array<mixed>|scalar|SettingsInterface>
     */
    public function toArray(): array
    {
        return $this->settings;
    }

    /**
     * @param string $id
     * @return array<mixed>|scalar|null|SettingsInterface
     */
    public function get(string $id)
    {
        return $this->settings[$id] ?? null;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->settings);
    }

    /**
     * @param array<mixed> $settings
     * @param bool $assertKeys
     * @throws InvalidArgumentException
     */
    private function assertSettings(array $settings, bool $assertKeys = true): void
    {
        foreach ($settings as $key => $value) {
            if ($assertKeys && (false === is_string($key) || '' === trim($key))) {
                throw InvalidArgumentException::forInvalidKey($key);
            }

            if (
                false === is_scalar($value)
                && false === is_array($value)
                && false === $value instanceof SettingsInterface
            ) {
                $type = is_object($value) ? get_class($value) : gettype($value);
                throw InvalidArgumentException::forInvalidValue($key, $type);
            }

            if (is_array($value)) {
                $this->assertSettings($value, false);
            }
        }
    }

    /**
     * @param SettingsInterface|array<string, array<mixed>|scalar|SettingsInterface> $settings1
     * @param SettingsInterface|array<string, array<mixed>|scalar|SettingsInterface> $settings2
     * @return SettingsInterface
     */
    abstract public static function merge(
        SettingsInterface|array $settings1,
        SettingsInterface|array $settings2
    ): SettingsInterface;
}
