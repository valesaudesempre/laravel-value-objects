<?php

namespace ValeSaude\LaravelValueObjects;

use Illuminate\Container\Container;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use ValeSaude\LaravelValueObjects\Casts\StringableValueObjectCast;
use ValeSaude\LaravelValueObjects\Concerns\HasFormatterTrait;
use ValeSaude\LaravelValueObjects\Contracts\StringableValueObjectInterface;
use ValeSaude\LaravelValueObjects\Formatters\Contracts\FormattableInterface;
use ValeSaude\LaravelValueObjects\Formatters\GenderFormatter;

class Gender extends AbstractValueObject implements StringableValueObjectInterface, FormattableInterface, Castable
{
    use HasFormatterTrait;

    private string $gender;

    public function __construct(string $gender)
    {
        if (!\in_array(strtolower($gender), ['m', 'f', 'o'])) {
            throw new InvalidArgumentException('The provided value is not a valid gender.');
        }

        $this->gender = strtoupper($gender);
    }

    public function __toString(): string
    {
        return $this->gender;
    }

    public function getFormatterClass(): string
    {
        return GenderFormatter::class;
    }

    /**
     * @param array<array-key, mixed> $arguments
     */
    public static function castUsing(array $arguments): CastsAttributes
    {
        return new StringableValueObjectCast(static::class);
    }

    public static function fromFormattedString(string $formattedString): self
    {
        return Container::getInstance()
            ->get(GenderFormatter::class)
            ->fromFormattedString($formattedString);
    }
}