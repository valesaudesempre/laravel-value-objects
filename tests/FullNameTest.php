<?php

use ValeSaude\LaravelValueObjects\Casts\FullNameCast;
use ValeSaude\LaravelValueObjects\FullName;

test('it handles first and last name correctly', function (string $firstName, string $expectedFirstName, string $lastName, string $expectedLastName) {
    // Given
    $instance = new FullName($firstName, $lastName);

    // Then
    expect($instance)->getFirstName()->toEqual($expectedFirstName)
        ->getLastName()->toEqual($expectedLastName);
})->with([
    'lower case' => ['first', 'First', 'last', 'Last'],
    'upper case' => ['FIRST', 'First', 'LAST', 'Last'],
    'mixed case' => ['fIrSt', 'First', 'lAsT', 'Last'],
    'with repeated spaces' => ['  first  ', 'First', '  last  ', 'Last'],
    'multiple last name words' => ['first', 'First', 'middle last', 'Middle Last'],
    'with multiple last name words with repeated spaces between words' => [
        'first',
        'First',
        'middle     last',
        'Middle Last',
    ],
]);

it('can be cast to string', function (string $firstName, string $lastName, string $expected) {
    // Given
    $instance = new FullName('First', 'Last');

    // Then
    expect((string) $instance)->toBe('First Last');
})->with([
    'last name with single word' => ['First', 'Last', 'First Last'],
    'last name with multiple words' => ['First', 'Middle Last', 'First Middle Last'],
]);

test('fromFullNameString throws when string has less than two parts', function (string $fullName) {
    $instance = FullName::fromFullNameString($fullName);
})->with([
    'empty string' => [''],
    'single word' => ['First'],
    'single word with repeated spaces' => ['  First   '],
])->throws(InvalidArgumentException::class, 'The full name must have at least two parts.');

test('fromFullNameString handles the full name correctly', function (string $fullName, string $expectedFirstName, string $expectedLastName) {
    // Given
    $instance = FullName::fromFullNameString($fullName);

    // Then
    expect($instance)->getFirstName()->toEqual($expectedFirstName)
        ->getLastName()->toEqual($expectedLastName);
})->with([
    'two words' => ['First Last', 'First', 'Last'],
    'three words' => ['First Middle Last', 'First', 'Middle Last'],
    'with repeated spaces between words' => ['  First   Last  ', 'First', 'Last'],
]);

test('castUsing returns a FullNameCast instance', function () {
    expect(FullName::castUsing([]))->toBeInstanceOf(FullNameCast::class);
});