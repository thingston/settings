<?php

declare(strict_types=1);

namespace Thingston\Tests\Settings;

use PHPUnit\Framework\TestCase;
use Thingston\Settings\Settings;
use Thingston\Settings\SettingsMergeTrait;

final class SettingsTest extends TestCase
{
    public function testMerge(): void
    {
        $settings1 = new Settings([
            'foo' => 'bar',
            'baz' => false,
            'settings' => new Settings(['foo' => 'bar']),
            'array' => ['first' => 1, 2],
        ]);

        $settings2 = new Settings([
            'baz' => true,
            'settings' => new Settings(['baz' => 'bee']),
            'array' => ['first' => 1, 'second' => 2, 4],
        ]);

        $settings = SettingsMergeTrait::merge($settings1, $settings2);

        $this->assertSame($settings1->get('foo'), $settings->get('foo'));
        $this->assertSame($settings2->get('baz'), $settings->get('baz'));
        $this->assertSame(
            array_merge((array) $settings1->get('array'), (array) $settings2->get('array')),
            $settings->get('array')
        );
    }
}
