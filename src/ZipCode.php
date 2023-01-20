<?php

namespace ValeSaude\LaravelValueObjects;

use Illuminate\Contracts\Database\Eloquent\Castable;
use InvalidArgumentException;
use ValeSaude\LaravelValueObjects\Casts\StringableValueObjectCast;
use ValeSaude\LaravelValueObjects\Contracts\StringableValueObjectInterface;
use ValeSaude\LaravelValueObjects\Formatters\Contracts\FormattableInterface;
use ValeSaude\LaravelValueObjects\Validators\ZipCodeValidator;

class ZipCode extends AbstractValueObject implements StringableValueObjectInterface, Castable, FormattableInterface
{
    private string $zipCode;

    public function __construct(string $zipCode)
    {
        $validator = new ZipCodeValidator();

        if (!$validator->validate($zipCode)) {
            throw new InvalidArgumentException('The provided value is not a valid ZipCode.');
        }

        $this->zipCode = $validator->sanitize($zipCode);
    }

    public function __toString(): string
    {
        return $this->zipCode;
    }

    public function format(): string
    {
        return sprintf('%s%s%s%s%s-%s%s%s', ...str_split($this->zipCode));
    }

    /**
     * @param array<array-key, mixed> $arguments
     */
    public static function castUsing(array $arguments): StringableValueObjectCast
    {
        return new StringableValueObjectCast(static::class);
    }
}
