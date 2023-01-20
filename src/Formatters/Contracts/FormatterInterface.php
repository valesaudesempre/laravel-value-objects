<?php

namespace ValeSaude\LaravelValueObjects\Formatters\Contracts;

interface FormatterInterface
{
    public function format(FormattableInterface $formattable): string;

    public function fromFormattedString(string $formattedString): FormattableInterface;
}