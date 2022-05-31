<?php

declare(strict_types=1);

namespace Thingston\Tests\Settings;

use Thingston\Settings\Settings;
use Thingston\Settings\SettingsInterface;
use PHPUnit\Framework\TestCase;

final class AbstractSettingsTest extends TestCase
{
    public function testConstruct(): void
    {
        $data = [
            'foo' => 'bar',
            'baz' => 1,
            'zed' => true,
            'settings' => new Settings(['zee' => 'bee']),
        ];

        $settings = new Settings($data);

        foreach ($data as $key => $value) {
            $this->assertTrue($settings->has($key));
            $this->assertSame($value, $settings->get($key));
        }

        foreach ($settings->toArray() as $key => $value) {
            $this->assertTrue(array_key_exists($key, $data));
            $this->assertSame($value, $data[$key]);
        }

        /** @var SettingsInterface $serialized */
        $serialized = unserialize(serialize($settings));
        $this->assertEquals($settings->toArray(), $serialized->toArray());
    }
}
