<?php

namespace ValeSaude\LaravelValueObjects\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use ValeSaude\LaravelValueObjects\FullName;

class FullNameCast implements CastsAttributes
{
    /**
     * @param string               $value
     * @param array<string, mixed> $attributes
     *
     */
    public function get($model, string $key, $value, array $attributes): ?FullName
    {
        if (!isset($value)) {
            return null;
        }

        return FullName::fromFullNameString($value);
    }

    /**
     * @param FullName|null        $value
     * @param array<string, mixed> $attributes
     */
    public function set($model, string $key, $value, array $attributes): ?string
    {
        if (!isset($value)) {
            return null;
        }

        if (!$value instanceof FullName) {
            throw new InvalidArgumentException('The given value is not a FullName instance.');
        }

        return (string) $value;
    }
}
