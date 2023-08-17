<?php

use ValeSaude\LaravelValueObjects\Formatters\GenderFormatter;
use ValeSaude\LaravelValueObjects\Gender;

beforeEach(function () {
    $this->sut = new GenderFormatter();
});

test('format returns expected value for each case', function (string $genderAsString, string $expected) {
    // Given
    $gender = new Gender($genderAsString);

    // When
    $formatted = $this->sut->format($gender);

    // Then
    expect($formatted)->toEqual($expected);
})->with([
    'masculino' => ['M', 'Masculino'],
    'feminino' => ['F', 'Feminino'],
    'outro' => ['O', 'Outro'],
]);

test('fromFormattedString throws when the provided string is not valid', function () {
    // Given
    $invalidString = 'invalid';

    // When
    $this->sut->fromFormattedString($invalidString);
})->throws(InvalidArgumentException::class, 'The formatted string is not valid.');

test('fromFormattedString returns expected value for each case', function (string $genderFormatted, string $expected) {
    // When
    $gender = $this->sut->fromFormattedString($genderFormatted);

    // Then
    expect($gender)->toEqual($expected);
})->with([
    'masculino' => ['masculino', 'M'],
    'feminino' => ['feminino', 'F'],
    'outro' => ['outro', 'O'],
    'upper case' => ['Masculino', 'M'],
    'mixed case' => ['MasCulino', 'M'],
]);