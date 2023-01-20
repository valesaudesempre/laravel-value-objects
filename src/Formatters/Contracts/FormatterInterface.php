<?php

namespace ValeSaude\ValueObjects\Formatters\Contracts;

interface FormatterInterface
{
    public function format(FormattableInterface $formattable): string;

    public function fromFormattedString(string $formattedString): FormattableInterface;
}