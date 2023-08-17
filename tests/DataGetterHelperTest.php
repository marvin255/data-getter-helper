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
     * @dataProvider provideScalar
     */
    public function testString(string $path, array|object $data, string|\Exception $awaits, string $default = ''): void
    {
        if ($awaits instanceof \Exception) {
            $this->expectExceptionObject($awaits);
        }

        $res = DataGetterHelper::string($path, $data, $default);

        $this->assertSame($awaits, $res);
    }

    public static function provideScalar(): array
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
}
