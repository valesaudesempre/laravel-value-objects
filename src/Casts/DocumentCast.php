<?php

namespace ValeSaude\LaravelValueObjects\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use ValeSaude\LaravelValueObjects\Document;
use ValeSaude\LaravelValueObjects\Enums\DocumentType;

class DocumentCast implements CastsAttributes
{
    /**
     * @param string                     $value
     * @param array<string, string|null> $attributes
     */
    public function get($model, string $key, $value, array $attributes): ?Document
    {
        $numberProperty = "{$key}_number";
        $typeProperty = "{$key}_type";

        if (!isset($attributes[$numberProperty]) && !isset($attributes[$typeProperty])) {
            return null;
        }

        if (!isset($attributes[$numberProperty], $attributes[$typeProperty])) {
            throw new InvalidArgumentException("Both {$numberProperty} and {$typeProperty} keys must be set or null.");
        }

        return new Document(
            $attributes[$numberProperty],
            DocumentType::from($attributes[$typeProperty])
        );
    }

    /**
     * @param Document|null        $value
     * @param array<string, mixed> $attributes
     *
     * @return array<string, string|null>
     */
    public function set($model, string $key, $value, array $attributes): array
    {
        $numberProperty = "{$key}_number";
        $typeProperty = "{$key}_type";

        if (!isset($value)) {
            return [$numberProperty => null, $typeProperty => null];
        }

        if (!$value instanceof Document) {
            throw new InvalidArgumentException('The given value is not a Document instance.');
        }

        return [
            $numberProperty => $value->getNumber(),
            $typeProperty => $value->getType(),
        ];
    }
}
