<?php

namespace ValeSaude\LaravelValueObjects\Formatters\Contracts;

interface FormattableInterface
{
    public function format(): string;
}