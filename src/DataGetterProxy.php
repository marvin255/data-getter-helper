<?php

declare(strict_types=1);

namespace Marvin255\DataGetterHelper;

/**
 * Proxy object that implements DataGetterHelper methods for nested content.
 *
 * @psalm-api
 */
final class DataGetterProxy
{
    private function __construct(private readonly array|object $data)
    {
    }

    /**
     * Wrap data with DataGetterProxy object.
     */
    public static function wrap(array|object $data): self
    {
        return new self($data);
    }

    /**
     * Try to extract string value from data by set path.
     *
     * @throws DataGetterException
     */
    public function string(string $path, string $default = DataGetterHelper::DEFAULT_STRING): string
    {
        return DataGetterHelper::string($path, $this->data, $default);
    }

    /**
     * Extract string or throw an exception if there is nothing.
     *
     * @throws DataGetterException
     */
    public function requireString(string $path): string
    {
        return DataGetterHelper::requireString($path, $this->data);
    }

    /**
     * Try to extract int value from data by set path.
     *
     * @throws DataGetterException
     */
    public function int(string $path, int $default = DataGetterHelper::DEFAULT_INT): int
    {
        return DataGetterHelper::int($path, $this->data, $default);
    }

    /**
     * Extract int or throw an exception if there is nothing.
     *
     * @throws DataGetterException
     */
    public function requireInt(string $path): int
    {
        return DataGetterHelper::requireInt($path, $this->data);
    }

    /**
     * Try to extract int value from data by set path.
     *
     * @throws DataGetterException
     */
    public function float(string $path, float $default = DataGetterHelper::DEFAULT_FLOAT): float
    {
        return DataGetterHelper::float($path, $this->data, $default);
    }

    /**
     * Extract int or throw an exception if there is nothing.
     *
     * @throws DataGetterException
     */
    public function requireFloat(string $path): float
    {
        return DataGetterHelper::requireFloat($path, $this->data);
    }

    /**
     * Try to extract bool value from data by set path.
     *
     * @throws DataGetterException
     */
    public function bool(string $path, bool $default = DataGetterHelper::DEFAULT_BOOL): bool
    {
        return DataGetterHelper::bool($path, $this->data, $default);
    }

    /**
     * Extract bool or throw an exception if there is nothing.
     *
     * @throws DataGetterException
     */
    public function requireBool(string $path): bool
    {
        return DataGetterHelper::requireBool($path, $this->data);
    }

    /**
     * Try to extract array value from data by set path.
     *
     * @return mixed[]
     *
     * @throws DataGetterException
     */
    public function array(string $path, array $default = DataGetterHelper::DEFAULT_ARRAY): array
    {
        return DataGetterHelper::array($path, $this->data, $default);
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
    public function arrayOf(string $path, callable $callback, array $default = DataGetterHelper::DEFAULT_ARRAY): array
    {
        return DataGetterHelper::arrayOf($path, $this->data, $callback, $default);
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
     * @throws DataGetterException
     */
    public function objectOf(string $path, string $class): object
    {
        return DataGetterHelper::objectOf($path, $this->data, $class);
    }

    /**
     * Returns data by set path.
     */
    public function get(string $path, mixed $default = null): mixed
    {
        return DataGetterHelper::get($path, $this->data, $default);
    }
}
