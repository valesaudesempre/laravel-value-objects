<?php

use ValeSaude\LaravelValueObjects\Casts\FullNameCast;
use ValeSaude\LaravelValueObjects\FullName;
use ValeSaude\LaravelValueObjects\Tests\Dummies\DummyModel;

beforeEach(fn () => $this->sut = new FullNameCast());

test('get returns FullName instance containing the given value', function () {
    // Given
    $value = 'First Last';

    // When
    $fullName = $this->sut->get(new DummyModel(), 'property', $value, []);

    // Then
    expect($fullName)->toBeInstanceOf(FullName::class)
        ->toEqual($value);
});

test('get returns null when value is null', function () {
    // When
    $fullName = $this->sut->get(new DummyModel(), 'property', null, []);

    // Then
    expect($fullName)->toBeNull();
});

test('set returns null when value is null', function () {
    // When
    $value = $this->sut->set(new DummyModel(), 'property', null, []);

    // Then
    expect($value)->toBeNull();
});

test('set throws InvalidArgumentException when value is not a FullName instance', function () {
    $value = $this->sut->set(new DummyModel(), 'property', 'First Last', []);
})->throws(InvalidArgumentException::class, 'The given value is not a FullName instance.');

test('set returns the full name as string', function () {
    // Given
    $fullName = new FullName('First', 'Last');

    // When
    $value = $this->sut->set(new DummyModel(), 'property', $fullName, []);

    // Then
    expect($value)->toBe('First Last');
});