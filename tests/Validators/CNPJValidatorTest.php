<?php

use ValeSaude\ValueObjects\Validators\CNPJValidator;

beforeEach(fn () => $this->sut = new CNPJValidator());

test('sanitize removes unwanted CNPJ characters', function () {
    // Given
    $cnpjWithMask = '75.344.646/0001-95';

    // When
    $sanitizedCnpj = $this->sut->sanitize($cnpjWithMask);

    // Then
    expect($sanitizedCnpj)->toEqual('75344646000195');
});

test('validate returns correctly validates CNPJs', function (string $cnpj, bool $expected) {
    // When
    $isCnpjValid = $this->sut->validate($cnpj);

    // Then
    expect($isCnpjValid)->toEqual($expected);
})->with([
    'valid CNPJ without mask' => [
        '75344646000195',
        true,
    ],
    'valid CNPJ with mask' => [
        '75.344.646/0001-95',
        true,
    ],
    'invalid CNPJ without mask' => [
        '12345678900001',
        false,
    ],
    'invalid CNPJ with mask' => [
        '12.345.678/9000-1',
        false,
    ],
    'string with less than 14 digits' => [
        '1111111111111',
        false,
    ],
    'CNPJ with repeated characters' => [
        '11111111111111',
        false,
    ],
]);
