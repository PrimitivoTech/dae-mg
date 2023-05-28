<?php

namespace Primitivo\DAE;

use ArrayAccess;
use BackedEnum;
use Carbon\Carbon;
use JsonSerializable;

/**
 * @see https://github.com/laravel/framework/blob/10.x/src/Illuminate/Support/Fluent.php
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @implements \ArrayAccess<TKey, TValue>
 */
class Fluent implements ArrayAccess, JsonSerializable
{
    /** @var array<TKey, TValue> */
    protected array $attributes = [];

    /** @var array<string, string> */
    protected $casts = [];

    /**
     * Create a new fluent instance.
     *
     * @param iterable<TKey, TValue> $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            $this->attributes[$key] = $value;
        }
    }

    /**
     * Get an attribute from the fluent instance.
     *
     * @template TGetDefault
     *
     * @param TKey $key
     * @param mixed|null $default
     * @return TValue|TGetDefault
     */
    public function get($key, mixed $default = null)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }

        return $default;
    }

    /**
     * @return array<TKey, TValue>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return array<TKey, TValue>
     */
    public function toArray(): array
    {
        return $this->castAttributes();
    }

    /**
     * @return array<TKey, TValue>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @param int $options
     * @return string
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * @param TKey $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->attributes[$offset]);
    }

    /**
     * @param TKey $offset
     * @return TValue|null
     */
    public function offsetGet($offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * @param TKey $offset
     * @param TValue $value
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        $this->attributes[$offset] = $value;
    }

    /**
     * @param TKey $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->attributes[$offset]);
    }

    /**
     * @param TKey $method
     * @param array{0: ?TValue} $parameters
     * @return $this
     */
    public function __call($method, array $parameters)
    {
        $this->attributes[$method] = count($parameters) > 0 ? reset($parameters) : true;

        return $this;
    }

    /**
     * @param TKey $key
     * @return TValue|null
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * @param TKey $key
     * @param TValue $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->offsetSet($key, $value);
    }

    /**
     * @param TKey $key
     * @return bool
     */
    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * @param TKey $key
     * @return void
     */
    public function __unset($key)
    {
        $this->offsetUnset($key);
    }

    protected function castAttributes(): array
    {
        $attributes = $this->attributes;

        foreach ($this->casts as $attribute => $type) {
            if (!array_key_exists($attribute, $attributes)) {
                continue;
            }

            if ($this->isEnum($type)) {
                $attributes[$attribute] = $this->castEnum($attributes[$attribute]);
                continue;
            }

            [$type, $options] = explode(':', $type);

            $attributes[$attribute] = $this->castAttribute($attributes[$attribute], $type, $options);
        }

        return $attributes;
    }

    protected function castAttribute(mixed $attribute, string $type, mixed $options = []): mixed
    {
        return match ($type) {
            'int', 'integer' => (int)$attribute,
            'float', 'double' => (float)$attribute,
            'date'  => $this->castDate($attribute, $options),
            default => $attribute,
        };
    }

    protected function isEnum($attribute): bool
    {
        return enum_exists($attribute);
    }

    protected function castEnum($attribute): string
    {
        return $attribute instanceof BackedEnum
            ? $attribute->value
            : $attribute->name;
    }

    protected function castDate(Carbon | string $attribute, string $format): string
    {
        return $attribute instanceof Carbon
            ? $attribute->format($format)
            : Carbon::parse($attribute)->format($format);
    }
}
