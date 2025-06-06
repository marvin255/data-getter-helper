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
    #[\PHPUnit\Framework\Attributes\DataProvider('provideString')]
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

    #[\PHPUnit\Framework\Attributes\DataProvider('provideRequireString')]
    public function testRequireString(string $path, array|object $data, string|\Exception $awaits): void
    {
        if ($awaits instanceof \Exception) {
            $this->expectExceptionObject($awaits);
        }

        $res = DataGetterHelper::requireString($path, $data);

        $this->assertSame($awaits, $res);
    }

    public static function provideRequireString(): array
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
            'non trimmed path' => [
                '  .test.  ',
                [
                    'test' => 'value',
                ],
                'value',
            ],
            'no value' => [
                'test',
                [],
                new DataGetterException("Item isn't found by path test"),
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

    #[\PHPUnit\Framework\Attributes\DataProvider('provideInt')]
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

    #[\PHPUnit\Framework\Attributes\DataProvider('provideRequireInt')]
    public function testRequireInt(string $path, array|object $data, int|\Exception $awaits): void
    {
        if ($awaits instanceof \Exception) {
            $this->expectExceptionObject($awaits);
        }

        $res = DataGetterHelper::requireInt($path, $data);

        $this->assertSame($awaits, $res);
    }

    public static function provideRequireInt(): array
    {
        $obj = new \stdClass();
        $obj->test = 123;

        return [
            'string from array' => [
                'test',
                [
                    'test' => '123',
                ],
                123,
            ],
            'int from array' => [
                'test',
                [
                    'test' => 123,
                ],
                123,
            ],
            'int from nested array' => [
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
            'non trimmed path' => [
                '  .test.  ',
                [
                    'test' => 123,
                ],
                123,
            ],
            'no value' => [
                'test',
                [],
                new DataGetterException("Item isn't found by path test"),
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

    #[\PHPUnit\Framework\Attributes\DataProvider('provideFloat')]
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

    #[\PHPUnit\Framework\Attributes\DataProvider('provideRequireFloat')]
    public function testRequireFloat(string $path, array|object $data, float|\Exception $awaits): void
    {
        if ($awaits instanceof \Exception) {
            $this->expectExceptionObject($awaits);
        }

        $res = DataGetterHelper::requireFloat($path, $data);

        $this->assertSame($awaits, $res);
    }

    public static function provideRequireFloat(): array
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
            'non trimmed path' => [
                '  .test.  ',
                [
                    'test' => 123.0,
                ],
                123.0,
            ],
            'no value' => [
                'test',
                [],
                new DataGetterException("Item isn't found by path test"),
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

    #[\PHPUnit\Framework\Attributes\DataProvider('provideBool')]
    public function testBool(string $path, array|object $data, bool|\Exception $awaits, bool $default = false): void
    {
        if ($awaits instanceof \Exception) {
            $this->expectExceptionObject($awaits);
        }

        $res = DataGetterHelper::bool($path, $data, $default);

        $this->assertSame($awaits, $res);
    }

    public static function provideBool(): array
    {
        $obj = new \stdClass();
        $obj->test = true;

        return [
            'float from array' => [
                'test',
                [
                    'test' => true,
                ],
                true,
            ],
            'string from array' => [
                'test',
                [
                    'test' => '1',
                ],
                true,
            ],
            'string from nested array' => [
                'test.test_1',
                [
                    'test' => [
                        'test_1' => true,
                    ],
                ],
                true,
            ],
            'string from object' => [
                'test',
                $obj,
                true,
            ],
            'default value' => [
                'test',
                [],
                true,
                true,
            ],
            'non trimmed path' => [
                '  .test.  ',
                [
                    'test' => false,
                ],
                false,
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

    #[\PHPUnit\Framework\Attributes\DataProvider('provideRequireBool')]
    public function testRequireBool(string $path, array|object $data, bool|\Exception $awaits): void
    {
        if ($awaits instanceof \Exception) {
            $this->expectExceptionObject($awaits);
        }

        $res = DataGetterHelper::requireBool($path, $data);

        $this->assertSame($awaits, $res);
    }

    public static function provideRequireBool(): array
    {
        $obj = new \stdClass();
        $obj->test = true;

        return [
            'bool from array' => [
                'test',
                [
                    'test' => true,
                ],
                true,
            ],
            'string from array' => [
                'test',
                [
                    'test' => '1',
                ],
                true,
            ],
            'bool from nested array' => [
                'test.test_1',
                [
                    'test' => [
                        'test_1' => true,
                    ],
                ],
                true,
            ],
            'bool from object' => [
                'test',
                $obj,
                true,
            ],
            'non trimmed path' => [
                '  .test.  ',
                [
                    'test' => false,
                ],
                false,
            ],
            'no value' => [
                'test',
                [],
                new DataGetterException("Item isn't found by path test"),
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

    #[\PHPUnit\Framework\Attributes\DataProvider('provideArray')]
    public function testArray(string $path, array|object $data, array|\Exception $awaits, array $default = []): void
    {
        if ($awaits instanceof \Exception) {
            $this->expectExceptionObject($awaits);
        }

        $res = DataGetterHelper::array($path, $data, $default);

        $this->assertSame($awaits, $res);
    }

    public static function provideArray(): array
    {
        $obj = new \stdClass();
        $obj->test = [123];

        return [
            'array from array' => [
                'test',
                [
                    'test' => [123, 321],
                ],
                [123, 321],
            ],
            'array from nested array' => [
                'test.test_1',
                [
                    'test' => [
                        'test_1' => [123],
                    ],
                ],
                [123],
            ],
            'string from object' => [
                'test',
                $obj,
                [123],
            ],
            'default value' => [
                'test',
                [],
                [123, 321],
                [123, 321],
            ],
            'non trimmed path' => [
                '  .test.  ',
                [
                    'test' => [123],
                ],
                [123],
            ],
            'non array exception' => [
                'test',
                [
                    'test' => 'test',
                ],
                new DataGetterException("Item found by path test isn't an array"),
            ],
        ];
    }

    public function testArrayOf(): void
    {
        $key = 'test';
        $data = [
            'test' => ['1', '2', '3'],
        ];
        $callback = fn (mixed $i): int => (int) $i;
        $awaits = [1, 2, 3];

        $res = DataGetterHelper::arrayOf($key, $data, $callback);

        $this->assertSame($awaits, $res);
    }

    /**
     * @psalm-param class-string $class
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('provideObjectOf')]
    public function testObjectOf(string $path, array|object $data, string $class, object $awaits): void
    {
        if ($awaits instanceof \Exception) {
            $this->expectExceptionObject($awaits);
        }

        $res = DataGetterHelper::objectOf($path, $data, $class);

        $this->assertSame($awaits, $res);
    }

    public static function provideObjectOf(): array
    {
        $object = new \stdClass();
        $class = \stdClass::class;

        return [
            'object from array' => [
                'test',
                [
                    'test' => $object,
                ],
                $class,
                $object,
            ],
            'object from nested array' => [
                'test.test_1',
                [
                    'test' => [
                        'test_1' => $object,
                    ],
                ],
                $class,
                $object,
            ],
            'non object exception' => [
                'test',
                [
                    'test' => 'test',
                ],
                $class,
                new DataGetterException(
                    "Item found by path test isn't an instance of " . \stdClass::class
                ),
            ],
            'wrong object class exception' => [
                'test',
                [
                    'test' => $object,
                ],
                self::class,
                new DataGetterException(
                    "Item found by path test isn't an instance of " . self::class
                ),
            ],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('provideGet')]
    public function testGet(string $path, array|object $data, mixed $awaits, mixed $default = null): void
    {
        if ($awaits instanceof \Exception) {
            $this->expectExceptionObject($awaits);
        }

        $res = DataGetterHelper::get($path, $data, $default);

        $this->assertSame($awaits, $res);
    }

    public static function provideGet(): array
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
                123,
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
            'no value' => [
                'test',
                [],
                'value',
                'value',
            ],
            'non trimmed path' => [
                '  .test.  ',
                [
                    'test' => 'value',
                ],
                'value',
            ],
            'non scalar' => [
                'test',
                [
                    'test' => [],
                ],
                [],
            ],
        ];
    }
}
