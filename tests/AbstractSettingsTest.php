<?php

declare(strict_types=1);

namespace Thingston\Tests\Settings;

use PHPUnit\Framework\TestCase;
use Thingston\Settings\Exception\InvalidArgumentException;
use Thingston\Settings\Settings;
use Thingston\Settings\SettingsInterface;

final class AbstractSettingsTest extends TestCase
{
    public function testConstruct(): void
    {
        $data = [
            'foo' => 'bar',
            'baz' => 1,
            'zed' => true,
            'array' => [1, true, 'foo', new Settings(['zee' => 'bee'])],
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

        $this->assertFalse($settings->has('boo'));
    }

    /**
     * @dataProvider invalidKeyProvider
     * @param array<string, array<mixed>|scalar|SettingsInterface> $settings
     */
    public function testInvalidKey(array $settings): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Settings($settings);
    }

    /**
     * @return array<array-key, array<array-key, mixed>>
     */
    public function invalidKeyProvider(): array
    {
        return [
            [['element with integer key']],
            [[0 => 'element with integer key']],
            [['' => 'element with empty string key']],
            [[' ' => 'element with empty string key']],
        ];
    }

    /**
     * @dataProvider invalidValueProvider
     * @param array<string, array<mixed>|scalar|SettingsInterface> $settings
     */
    public function testInvalidValue(array $settings): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Settings($settings);
    }

    /**
     * @return array<array-key, array<array-key, mixed>>
     */
    public function invalidValueProvider(): array
    {
        return [
            [['null' => null]],
            [['object' => $this]],
            [['function' => function () {
            }]],
            [['array' => [function () {
            }]]],
        ];
    }
}
