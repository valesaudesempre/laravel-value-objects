<?php

namespace ValeSaude\LaravelValueObjects\Formatters;

use Illuminate\Support\Str;
use InvalidArgumentException;
use ValeSaude\LaravelValueObjects\Formatters\Contracts\FormattableInterface;
use ValeSaude\LaravelValueObjects\Formatters\Contracts\FormatterInterface;
use ValeSaude\LaravelValueObjects\Money;

class MoneyFormatter implements FormatterInterface
{
    /**
     * @param Money $formattable
     */
    public function format(FormattableInterface $formattable): string
    {
        // TODO: Refatorar para utilizar NumberFormatter, utilizando Currency existente no VO
        return number_format($formattable->toFloat(), 2, ',', '.');
    }

    /**
     * @return Money
     */
    public function fromFormattedString(string $formattedString): FormattableInterface
    {
        // TODO: Refatorar para utilizar NumberFormatter
        if (!preg_match('/^(R\$ ?)?([1-9]\d{0,2}(\.\d{3})*|\d+)(\,\d{2})?$/', $formattedString)) {
            throw new InvalidArgumentException('The formatted string is not valid.');
        }

        if (!Str::contains($formattedString, ',')) {
            $formattedString .= ',00';
        }

        return new Money((int) preg_replace('/\D/', '', $formattedString));
    }
}