<?php

use ValeSaude\LaravelValueObjects\Generators\CPFGenerator;
use ValeSaude\LaravelValueObjects\Validators\CPFValidator;

beforeEach(function () {
    $this->generator = new CPFGenerator();
    $this->cpfValidator = new CPFValidator();
});

it('generates a valid CPF', function () {
    // Repeats the generation 1000 times to ensure that the generated CPF is valid
    foreach (range(1, 1000) as $i) {
        // Given
        $cpf = $this->generator->generate();

        // Then
        expect($this->cpfValidator->validate($cpf))->toBeTrue();
    }
});