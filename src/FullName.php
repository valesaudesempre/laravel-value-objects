<?php

namespace ValeSaude\LaravelValueObjects;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use ValeSaude\LaravelValueObjects\Casts\FullNameCast;
use ValeSaude\LaravelValueObjects\Contracts\StringableValueObjectInterface;

class FullName extends AbstractValueObject implements StringableValueObjectInterface, Castable
{
    private string $firstName;
    private string $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = ucfirst(strtolower(self::removeRepeatedSpacesBetweenWords($firstName)));
        $this->lastName = ucwords(strtolower(self::removeRepeatedSpacesBetweenWords($lastName)));
    }

    public function __toString(): string
    {
        return sprintf('%s %s', $this->firstName, $this->lastName);
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public static function fromFullNameString(string $fullName): self
    {
        $parts = array_filter(explode(' ', $fullName));

        if (count($parts) < 2) {
            throw new InvalidArgumentException('The full name must have at least two parts.');
        }

        return new self(
            array_shift($parts),
            implode(' ', $parts)
        );
    }

    /**
     * @param array<string, mixed> $arguments
     */
    public static function castUsing(array $arguments): CastsAttributes
    {
        return new FullNameCast();
    }

    private static function removeRepeatedSpacesBetweenWords(string $fullName): string
    {
        return implode(' ', array_filter(explode(' ', $fullName)));
    }
}