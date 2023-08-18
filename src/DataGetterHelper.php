<?php

declare(strict_types=1);

namespace Marvin255\DataGetterHelper;

/**
 * Helper that can extract typed values from mixed data.
 *
 * @psalm-api
 */
final class DataGetterHelper
{
    private const DEFAULT_STRING = '';
    private const DEFAULT_INT = 0;
    private const DEFAULT_FLOAT = .0;
    private const DEFAULT_BOOL = false;
    private const DEFAULT_ARRAY = [];

    /**
     * @psalm-suppress UnusedConstructor
     */
    private function __construct()
    {
    }

    /**
     * Try to extract string value from data by set path.
     *
     * @throws DataGetterException
     */
    public static function string(string $path, array|object $data, string $default = self::DEFAULT_STRING): string
    {
        $value = self::scalar($path, $data);

        return $value === null ? $default : (string) $value;
    }

    /**
     * Extract string or throw an exception if there is nothing.
     *
     * @throws DataGetterException
     */
    public static function requireString(string $path, array|object $data): string
    {
        $value = self::scalar($path, $data);

        if ($value === null) {
            throw new DataGetterException("Item isn't found by path {$path}");
        }

        return (string) $value;
    }

    /**
     * Try to extract int value from data by set path.
     *
     * @throws DataGetterException
     */
    public static function int(string $path, array|object $data, int $default = self::DEFAULT_INT): int
    {
        $value = self::scalar($path, $data);

        if ($value !== null && !is_numeric($value)) {
            throw new DataGetterException("Item found by path {$path} isn't an int number");
        }

        return $value === null ? $default : (int) $value;
    }

    /**
     * Extract int or throw an exception if there is nothing.
     *
     * @throws DataGetterException
     */
    public static function requireInt(string $path, array|object $data): int
    {
        $value = self::scalar($path, $data);

        if ($value === null) {
            throw new DataGetterException("Item isn't found by path {$path}");
        }

        if (!is_numeric($value)) {
            throw new DataGetterException("Item found by path {$path} isn't an int number");
        }

        return (int) $value;
    }

    /**
     * Try to extract int value from data by set path.
     *
     * @throws DataGetterException
     */
    public static function float(string $path, array|object $data, float $default = self::DEFAULT_FLOAT): float
    {
        $value = self::scalar($path, $data);

        if ($value !== null && !is_numeric($value)) {
            throw new DataGetterException("Item found by path {$path} isn't a float number");
        }

        return $value === null ? $default : (float) $value;
    }

    /**
     * Extract int or throw an exception if there is nothing.
     *
     * @throws DataGetterException
     */
    public static function requireFloat(string $path, array|object $data): float
    {
        $value = self::scalar($path, $data);

        if ($value === null) {
            throw new DataGetterException("Item isn't found by path {$path}");
        }

        if (!is_numeric($value)) {
            throw new DataGetterException("Item found by path {$path} isn't a float number");
        }

        return (float) $value;
    }

    /**
     * Try to extract bool value from data by set path.
     *
     * @throws DataGetterException
     */
    public static function bool(string $path, array|object $data, bool $default = self::DEFAULT_BOOL): bool
    {
        $value = self::scalar($path, $data);

        return $value === null ? $default : (bool) $value;
    }

    /**
     * Extract bool or throw an exception if there is nothing.
     *
     * @throws DataGetterException
     */
    public static function requireBool(string $path, array|object $data): bool
    {
        $value = self::scalar($path, $data);

        if ($value === null) {
            throw new DataGetterException("Item isn't found by path {$path}");
        }

        return (bool) $value;
    }

    /**
     * Try to extract array value from data by set path.
     *
     * @return mixed[]
     *
     * @throws DataGetterException
     */
    public static function array(string $path, array|object $data, array $default = self::DEFAULT_ARRAY): array
    {
        $value = self::get($path, $data);

        if ($value === null) {
            return $default;
        }

        if (!\is_array($value)) {
            throw new DataGetterException("Item found by path {$path} isn't an array");
        }

        return $value;
    }

    /**
     * Try to extract and map array value from data by set path.
     *
     * @template T
     *
     * @psalm-param callable(mixed): T $callback
     *
     * @psalm-return T[]
     *
     * @throws DataGetterException
     */
    public static function arrayOf(string $path, array|object $data, callable $callback, array $default = self::DEFAULT_ARRAY): array
    {
        return array_map(
            $callback,
            self::array($path, $data, $default)
        );
    }

    /**
     * Try to extract and map array value from data by set path.
     *
     * @template T
     *
     * @psalm-param class-string<T> $class
     *
     * @psalm-return T
     *
     * @return mixed
     *
     * @throws DataGetterException
     *
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress InvalidReturnStatement
     */
    public static function objectOf(string $path, array|object $data, string $class): object
    {
        $value = self::get($path, $data);

        if (!is_a($value, $class)) {
            throw new DataGetterException("Item found by path {$path} isn't an instance of {$class}");
        }

        return $value;
    }

    /**
     * Returns data by set path.
     *
     * @psalm-suppress MixedAssignment
     */
    public static function get(string $path, array|object $data): mixed
    {
        $arPath = self::explodePath($path);

        $item = $data;
        foreach ($arPath as $chainItem) {
            if (\is_array($item) && \array_key_exists($chainItem, $item)) {
                $item = $item[$chainItem];
            } elseif (\is_object($item) && property_exists($item, $chainItem)) {
                $item = $item->$chainItem;
            } else {
                return null;
            }
        }

        return $item;
    }

    /**
     * @psalm-return scalar
     */
    private static function scalar(string $path, array|object $data): int|float|bool|string|null
    {
        $res = self::get($path, $data);

        if (!\is_scalar($res) && $res !== null) {
            throw new DataGetterException("Item found by path {$path} isn't scalar");
        }

        return $res;
    }

    /**
     * Explodes dotted path to array of items.
     *
     * @return string[]
     */
    private static function explodePath(string $path): array
    {
        return explode('.', trim($path, " \n\r\t\v\0."));
    }
}
