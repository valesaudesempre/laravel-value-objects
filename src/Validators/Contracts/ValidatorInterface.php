<?php

namespace ValeSaude\LaravelValueObjects\Validators\Contracts;

interface ValidatorInterface
{
    public function sanitize(string $value): string;

    public function validate(string $value): bool;
}
