<?php

namespace ValeSaude\LaravelValueObjects;

use Illuminate\Contracts\Database\Eloquent\Castable;
use InvalidArgumentException;
use ValeSaude\LaravelValueObjects\Casts\StringableValueObjectCast;
use ValeSaude\LaravelValueObjects\Contracts\StringableValueObjectInterface;
use ValeSaude\LaravelValueObjects\Validators\PhoneValidator;

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

    public function getAreaCode(): string
    {
        return substr($this->phone, 0, 2);
    }

    public function getNumber(): string
    {
        return substr($this->phone, 2);
    }

    /**
     * @param array<array-key, mixed> $arguments
     */
    public static function castUsing(array $arguments): StringableValueObjectCast
    {
        return new StringableValueObjectCast(static::class);
    }
}
