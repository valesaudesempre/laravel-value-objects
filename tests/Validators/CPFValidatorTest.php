<?php

use ValeSaude\LaravelValueObjects\Validators\CPFValidator;

beforeEach(fn () => $this->sut = new CPFValidator());

test('sanitize removes unwanted CPF characters', function () {
    // Given
    $cpfWithMask = '744.064.330-58';

    // When
    $sanitizedCpf = $this->sut->sanitize($cpfWithMask);

    // Then
    expect($sanitizedCpf)->toEqual('74406433058');
});

test('validate returns correctly validates CPFs', function (string $cpf, bool $expected) {
    // When
    $isCpfValid = $this->sut->validate($cpf);

    // Then
    expect($isCpfValid)->toEqual($expected);
})->with([
    'valid CPF without mask' => [
        '74406433058',
        true,
    ],
    'valid CPF with mask' => [
        '744.064.330-58',
        true,
    ],
    'invalid CPF without mask' => [
        '12345678901',
        false,
    ],
    'invalid CPF with mask' => [
        '123.456.789-01',
        false,
    ],
    'string with less than 11 digits' => [
        '1111111111',
        false,
    ],
    'CPF with repeated characters' => [
        '11111111111',
        false,
    ],
]);
