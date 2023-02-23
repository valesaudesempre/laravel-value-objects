<?php

use ValeSaude\LaravelValueObjects\Casts\MoneyCast;
use ValeSaude\LaravelValueObjects\Money;
use ValeSaude\LaravelValueObjects\Tests\Dummies\DummyModel;

beforeEach(fn () => $this->sut = new MoneyCast());

test('get returns Money instance containing the given value', function () {
    // Given
    $value = 12345;

    // When
    $money = $this->sut->get(new DummyModel(), 'property', $value, []);

    // Then
    expect($money)->toBeInstanceOf(Money::class)
        ->getCents()->toEqual($value);
});

test('get returns null when value is null', function () {
    // When
    $money = $this->sut->get(new DummyModel(), 'property', null, []);

    // Then
    expect($money)->toBeNull();
});

test('set returns the value in cents', function () {
    // Given
    $money = new Money(12345);

    // When
    $value = $this->sut->set(new DummyModel(), 'property', $money, []);

    // Then
    expect($value)->toBe(12345);
});

test('set returns null when value is null', function () {
    // When
    $value = $this->sut->set(new DummyModel(), 'property', null, []);

    // Then
    expect($value)->toBeNull();
});