<?php

declare(strict_types=1);

namespace Thingston\Tests\Settings;

use PHPUnit\Framework\TestCase;
use Thingston\Settings\Exception\InvalidArgumentException;
use Thingston\Settings\SettingsFactory;
use Thingston\Settings\SettingsInterface;

final class SettingsFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $settings = SettingsFactory::create(['foo' => 'bar']);

        $this->assertInstanceOf(SettingsInterface::class, $settings);
    }

    public function testFromFile(): void
    {
        $settings = SettingsFactory::fromFile(__DIR__ . '/settings.php');

        $this->assertInstanceOf(SettingsInterface::class, $settings);
    }

    public function testFromFileNotFound(): void
    {
        $this->expectException(InvalidArgumentException::class);
        SettingsFactory::fromFile(__DIR__ . '/not_found.php');
    }

    public function testFromFileInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        SettingsFactory::fromFile(__DIR__ . '/invalid.php');
    }

    public function testFromDirectory(): void
    {
        $settings = SettingsFactory::fromDir(__DIR__ . '/config');

        $env = include __DIR__ . '/config/env.php';
        $locale = include __DIR__ . '/config/locale.php';

        $this->assertInstanceOf(SettingsInterface::class, $settings);
        $this->assertInstanceOf(SettingsInterface::class, $settings->get('env'));
        $this->assertInstanceOf(SettingsInterface::class, $settings->get('locale'));

        /** @var SettingsInterface $envSettings */
        $envSettings = $settings->get('env');
        $this->assertSame($env, $envSettings->toArray());

        /** @var SettingsInterface $localeSettings */
        $localeSettings = $settings->get('locale');
        $this->assertSame($locale, $localeSettings->toArray());
    }

    public function testFromDirectoryRecursive(): void
    {
        $settings = SettingsFactory::fromDir(__DIR__ . '/config', true);

        $env = array_merge(include __DIR__ . '/config/env.php', include __DIR__ . '/config/dev/env.php');
        $locale = include __DIR__ . '/config/locale.php';

        $this->assertInstanceOf(SettingsInterface::class, $settings);
        $this->assertInstanceOf(SettingsInterface::class, $settings->get('env'));
        $this->assertInstanceOf(SettingsInterface::class, $settings->get('locale'));

        /** @var SettingsInterface $envSettings */
        $envSettings = $settings->get('env');
        $this->assertSame($env, $envSettings->toArray());

        /** @var SettingsInterface $localeSettings */
        $localeSettings = $settings->get('locale');
        $this->assertSame($locale, $localeSettings->toArray());
    }

    public function testFromDirectoryInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        SettingsFactory::fromDir(__DIR__ . '/invalid.php');
    }
}
