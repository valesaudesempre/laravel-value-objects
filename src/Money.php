<?php

namespace ValeSaude\LaravelValueObjects;

use Illuminate\Container\Container;
use Illuminate\Contracts\Database\Eloquent\Castable;
use ValeSaude\LaravelValueObjects\Casts\MoneyCast;
use ValeSaude\LaravelValueObjects\Concerns\HasFormatterTrait;
use ValeSaude\LaravelValueObjects\Formatters\Contracts\FormattableInterface;
use ValeSaude\LaravelValueObjects\Formatters\MoneyFormatter;

class Money extends AbstractValueObject implements Castable, FormattableInterface
{
    use HasFormatterTrait;

    private int $cents;

    public function __construct(int $cents)
    {
        $this->cents = $cents;
    }

    public function getCents(): int
    {
        return $this->cents;
    }

    public function toFloat(): float
    {
        return round($this->cents / 100, 2);
    }

    public function sum(int $number): self
    {
        return new self($this->cents + $number);
    }

    public function subtract(int $number): self
    {
        return new self($this->cents - $number);
    }

    /**
     * @param int|float $multiplier
     */
    public function multiply($multiplier): self
    {
        return new self((int) round($this->cents * $multiplier));
    }

    /**
     * @param int|float $divisor
     *
     * @return self
     */
    public function divide($divisor): self
    {
        return new self((int) round($this->cents / $divisor));
    }

    /**
     * @param int|float $percentage
     */
    public function percentage($percentage): self
    {
        return $this->multiply($percentage / 100);
    }

    public function getFormatterClass(): string
    {
        return MoneyFormatter::class;
    }

    /**
     * @param array<array-key, mixed> $arguments
     */
    public static function castUsing(array $arguments): MoneyCast
    {
        return new MoneyCast();
    }

    public static function zero(): self
    {
        return new self(0);
    }

    public static function fromFloat(float $value): self
    {
        return new self((int) round($value * 100));
    }

    public static function fromFormattedString(string $formattedString): self
    {
        return Container::getInstance()
            ->get(MoneyFormatter::class)
            ->fromFormattedString($formattedString);
    }
}
