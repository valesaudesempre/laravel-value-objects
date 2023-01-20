<?php

namespace ValeSaude\ValueObjects\Formatters\Contracts;

interface FormattableInterface
{
    public function format(): string;
}