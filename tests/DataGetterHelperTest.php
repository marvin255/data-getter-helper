<?php

declare(strict_types=1);

namespace Marvin255\DataGetterHelper\Tests;

use Marvin255\DataGetterHelper\DataGetterException;
use Marvin255\DataGetterHelper\DataGetterHelper;

/**
 * @internal
 */
final class DataGetterHelperTest extends BaseCase
{
    /**
     * @dataProvider provideString
     */
    public function testString(string $path, array|object $data, string|\Exception $awaits, string $default = ''): void
    {
        if ($awaits instanceof \Exception) {
            $this->expectExceptionObject($awaits);
        }

        $res = DataGetterHelper::string($path, $data, $default);

        $this->assertSame($awaits, $res);
    }

    public static function provideString(): array
    {
        $obj = new \stdClass();
        $obj->test = 'value';

        return [
            'string from array' => [
                'test',
                [
                    'test' => 'value',
                ],
                'value',
            ],
            'int from array' => [
                'test',
                [
                    'test' => 123,
                ],
                '123',
            ],
            'string from nested array' => [
                'test.test_1',
                [
                    'test' => [
                        'test_1' => 'value',
                    ],
                ],
                'value',
            ],
            'string from object' => [
                'test',
                $obj,
                'value',
            ],
            'default value' => [
                'test',
                [],
                'default value',
                'default value',
            ],
            'non trimmed path' => [
                '  .test.  ',
                [
                    'test' => 'value',
                ],
                'value',
            ],
            'non scalar exception' => [
                'test',
                [
                    'test' => [],
                ],
                new DataGetterException("Item found by path test isn't scalar"),
            ],
        ];
    }

    /**
     * @dataProvider provideInt
     */
    public function testInt(string $path, array|object $data, int|\Exception $awaits, int $default = 0): void
    {
        if ($awaits instanceof \Exception) {
            $this->expectExceptionObject($awaits);
        }

        $res = DataGetterHelper::int($path, $data, $default);

        $this->assertSame($awaits, $res);
    }

    public static function provideInt(): array
    {
        $obj = new \stdClass();
        $obj->test = 123;

        return [
            'int from array' => [
                'test',
                [
                    'test' => 123,
                ],
                123,
            ],
            'string from array' => [
                'test',
                [
                    'test' => '123',
                ],
                123,
            ],
            'string from nested array' => [
                'test.test_1',
                [
                    'test' => [
                        'test_1' => 123,
                    ],
                ],
                123,
            ],
            'string from object' => [
                'test',
                $obj,
                123,
            ],
            'default value' => [
                'test',
                [],
                321,
                321,
            ],
            'non trimmed path' => [
                '  .test.  ',
                [
                    'test' => 123,
                ],
                123,
            ],
            'non scalar exception' => [
                'test',
                [
                    'test' => [],
                ],
                new DataGetterException("Item found by path test isn't scalar"),
            ],
            'not a number exception' => [
                'test',
                [
                    'test' => 'test',
                ],
                new DataGetterException("Item found by path test isn't an int number"),
            ],
        ];
    }

    /**
     * @dataProvider provideFloat
     */
    public function testFloat(string $path, array|object $data, float|\Exception $awaits, float $default = .0): void
    {
        if ($awaits instanceof \Exception) {
            $this->expectExceptionObject($awaits);
        }

        $res = DataGetterHelper::float($path, $data, $default);

        $this->assertSame($awaits, $res);
    }

    public static function provideFloat(): array
    {
        $obj = new \stdClass();
        $obj->test = 123.0;

        return [
            'float from array' => [
                'test',
                [
                    'test' => 123.1,
                ],
                123.1,
            ],
            'string from array' => [
                'test',
                [
                    'test' => '123.1',
                ],
                123.1,
            ],
            'string from nested array' => [
                'test.test_1',
                [
                    'test' => [
                        'test_1' => 123.1,
                    ],
                ],
                123.1,
            ],
            'string from object' => [
                'test',
                $obj,
                123.0,
            ],
            'default value' => [
                'test',
                [],
                321.0,
                321.0,
            ],
            'non trimmed path' => [
                '  .test.  ',
                [
                    'test' => 123.0,
                ],
                123.0,
            ],
            'non scalar exception' => [
                'test',
                [
                    'test' => [],
                ],
                new DataGetterException("Item found by path test isn't scalar"),
            ],
            'not a number exception' => [
                'test',
                [
                    'test' => 'test',
                ],
                new DataGetterException("Item found by path test isn't a float number"),
            ],
        ];
    }
}
