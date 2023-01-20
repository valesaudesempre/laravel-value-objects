<?php

namespace ValeSaude\LaravelValueObjects\Contracts;

use JsonSerializable;

interface JsonSerializableValueObjectInterface extends JsonSerializable
{
    /**
     * @param array<string, mixed> $attributes
     *
     * @return static
     */
    public static function fromArray(array $attributes): self;
}
