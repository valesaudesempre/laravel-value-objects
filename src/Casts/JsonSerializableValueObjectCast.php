<?php

namespace ValeSaude\LaravelValueObjects\Casts;

use JsonException;
use ValeSaude\LaravelValueObjects\Contracts\JsonSerializableValueObjectInterface;
use ValeSaude\LaravelValueObjects\Utils\JSON;

/**
 * @template-extends AbstractValueObjectCast<JsonSerializableValueObjectInterface>
 */
class JsonSerializableValueObjectCast extends AbstractValueObjectCast
{
    /**
     * @param string               $value
     * @param array<string, mixed> $attributes
     *
     * @throws JsonException
     */
    public function get($model, string $key, $value, array $attributes): JsonSerializableValueObjectInterface
    {
        $class = $this->valueObjectClass;

        return $class::fromArray(JSON::decode($value));
    }

    /**
     * @param JsonSerializableValueObjectInterface $value
     * @param array<string, mixed>                 $attributes
     *
     * @throws JsonException
     */
    public function set($model, string $key, $value, array $attributes): string
    {
        return JSON::encode($value);
    }
}
