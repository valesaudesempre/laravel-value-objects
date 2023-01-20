<?php

namespace ValeSaude\ValueObjects;

use Illuminate\Contracts\Database\Eloquent\Castable;
use InvalidArgumentException;
use ValeSaude\ValueObjects\Casts\StringableValueObjectCast;
use ValeSaude\ValueObjects\Contracts\StringableValueObjectInterface;
use ValeSaude\ValueObjects\Validators\PhoneValidator;

class Phone extends AbstractValueObject implements StringableValueObjectInterface, Castable
{
    private string $phone;

    public function __construct(string $phone)
    {
        $validator = new PhoneValidator();

        if (!$validator->validate($phone)) {
            throw new InvalidArgumentException('The provided value is not a valid phone.');
        }

        $this->phone = $validator->sanitize($phone);
    }

    public function __toString(): string
    {
        return $this->phone;
    }

    /**
     * @param array<array-key, mixed> $arguments
     */
    public static function castUsing(array $arguments): StringableValueObjectCast
    {
        return new StringableValueObjectCast(static::class);
    }
}
