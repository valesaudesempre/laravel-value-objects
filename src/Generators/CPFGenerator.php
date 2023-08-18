<?php

namespace ValeSaude\LaravelValueObjects\Generators;

use ValeSaude\LaravelValueObjects\Generators\Contracts\GeneratorInterface;

class CPFGenerator implements GeneratorInterface
{
    public function generate(): string
    {
        $digits = array_map(static fn () => random_int(0, 9), range(1, 9));
        // Calculate the first verification digit
        $digits[] = $this->calculateVerificationDigit($digits);
        // Calculate the second verification digit
        $digits[] = $this->calculateVerificationDigit($digits);

        return implode('', $digits);
    }

    /**
     * @param array<array-key, int> $digits
     */
    private function calculateVerificationDigit(array $digits): int
    {
        $sum = 0;
        $multiplier = count($digits) + 1;

        foreach ($digits as $digit) {
            $sum += $digit * $multiplier;
            $multiplier--;
        }

        $remainder = $sum % 11;

        if ($remainder < 2) {
            return 0;
        }

        return 11 - $remainder;
    }
}