<?php

namespace ValeSaude\LaravelValueObjects\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use ValeSaude\LaravelValueObjects\Document;
use ValeSaude\LaravelValueObjects\Enums\DocumentType;

class DocumentCast implements CastsAttributes
{
    /**
     * @param string                                                          $value
     * @param array{document_type: string|null, document_number: string|null} $attributes
     */
    public function get($model, string $key, $value, array $attributes): ?Document
    {
        if (!isset($attributes['document_number']) && !isset($attributes['document_type'])) {
            return null;
        }

        if (!isset($attributes['document_number'], $attributes['document_type'])) {
            throw new InvalidArgumentException('Both document_number and document_type keys must be set or null.');
        }

        return new Document(
            $attributes['document_number'],
            DocumentType::from($attributes['document_type'])
        );
    }

    /**
     * @param Document|null        $value
     * @param array<string, mixed> $attributes
     *
     * @return array{document_type: string|null, document_number: string|null}
     */
    public function set($model, string $key, $value, array $attributes): array
    {
        if (!isset($value)) {
            return ['document_number' => null, 'document_type' => null];
        }

        if (!$value instanceof Document) {
            throw new InvalidArgumentException('The given value is not a Document instance.');
        }

        return [
            'document_number' => $value->getNumber(),
            'document_type' => $value->getType(),
        ];
    }
}
