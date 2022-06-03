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
}
