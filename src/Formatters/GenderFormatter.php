<?php

namespace ValeSaude\LaravelValueObjects\Formatters;

use InvalidArgumentException;
use ValeSaude\LaravelValueObjects\Formatters\Contracts\FormattableInterface;
use ValeSaude\LaravelValueObjects\Formatters\Contracts\FormatterInterface;
use ValeSaude\LaravelValueObjects\Gender;

class GenderFormatter implements FormatterInterface
{
    private const GENDER_MAPPING = [
        'M' => 'masculino',
        'F' => 'feminino',
        'O' => 'outro',
    ];

    /**
     * @param Gender $formattable
     */
    public function format(FormattableInterface $formattable): string
    {
        return ucfirst(self::GENDER_MAPPING[(string) $formattable]);
    }

    public function fromFormattedString(string $formattedString): FormattableInterface
    {
        $stringAsLowerCase = strtolower($formattedString);

        if (!\in_array($stringAsLowerCase, self::GENDER_MAPPING)) {
            throw new InvalidArgumentException('The formatted string is not valid.');
        }

        return new Gender(array_flip(self::GENDER_MAPPING)[strtolower($formattedString)]);
    }
}