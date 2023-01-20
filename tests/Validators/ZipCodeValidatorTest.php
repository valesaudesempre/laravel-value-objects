<?php

use ValeSaude\LaravelValueObjects\Validators\ZipCodeValidator;

beforeEach(fn () => $this->sut = new ZipCodeValidator());

test('sanitize removes unwanted ZipCode characters', function () {
    // Given
    $zipCodeWithMask = '01001-000';

    // When
    $sanitizedZipCode = $this->sut->sanitize($zipCodeWithMask);

    // Then
    expect($sanitizedZipCode)->toEqual('01001000');
});

test('validate returns correctly validates ZipCodes', function (string $zipCode, bool $expected) {
    // When
    $isZipCodeValid = $this->sut->validate($zipCode);

    // Then
    expect($isZipCodeValid)->toEqual($expected);
})->with([
    'valid ZipCode without mask' => [
        '01001000',
        true,
    ],
    'valid ZipCode with mask' => [
        '01001-000',
        true,
    ],
    'invalid ZipCode' => [
        'some random string',
        false,
    ],
    'ZipCode with leading characters' => [
        '99901001000',
        false,
    ],
    'ZipCode with trailing characters' => [
        '01001000999',
        false,
    ],
]);
