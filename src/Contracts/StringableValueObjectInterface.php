<?php

namespace ValeSaude\ValueObjects\Contracts;

use ValeSaude\ValueObjects\AbstractValueObject;

/**
 * @mixin AbstractValueObject
 */
interface StringableValueObjectInterface
{
    public function __toString(): string;
}
