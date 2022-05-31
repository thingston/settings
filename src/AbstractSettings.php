<?php

declare(strict_types=1);

namespace Thingston\Settings;

abstract class AbstractSettings implements SettingsInterface
{
    /**
     * @param array<string, scalar|SettingsInterface> $settings
     */
    public function __construct(private array $settings = [])
    {
        $this->settings = $settings;
    }

    /**
     * @return array<string, scalar|SettingsInterface>
     */
    public function __serialize(): array
    {
        return $this->settings;
    }

    /**
     * @param array<string, scalar|SettingsInterface> $data
     */
    public function __unserialize(array $data): void
    {
        $this->settings = $data;
    }

    /**
     * @return array<string, scalar|SettingsInterface>
     */
    public function toArray(): array
    {
        return $this->settings;
    }

    /**
     * @param string $id
     * @return scalar|null|SettingsInterface
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
}
