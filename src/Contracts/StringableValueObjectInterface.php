<?php

namespace ValeSaude\LaravelValueObjects\Contracts;

use ValeSaude\LaravelValueObjects\AbstractValueObject;

/**
 * @mixin AbstractValueObject
 */
interface StringableValueObjectInterface
{
    public function __toString(): string;
}
