<?php

namespace ValeSaude\ValueObjects\Validators\Contracts;

interface ValidatorInterface
{
    public function sanitize(string $value): string;

    public function validate(string $value): bool;
}
