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
    /**
     * @psalm-suppress UnusedConstructor
     */
    private function __construct()
    {
    }

    /**
     * Try ti extract string value from data by set path.
     *
     * @throws DataGetterException
     */
    public static function string(string $path, array|object $data, string $default = ''): string
    {
        $value = self::scalar($path, $data);

        return $value === null ? $default : (string) $value;
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
     * Returns data by set path.
     *
     * @psalm-suppress MixedAssignment
     */
    private static function get(string $path, array|object $data): mixed
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
     * Explodes dotted path to array of items.
     *
     * @return string[]
     */
    private static function explodePath(string $path): array
    {
        return explode('.', trim($path, " \n\r\t\v\0."));
    }
}
