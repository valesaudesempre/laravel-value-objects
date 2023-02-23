<?php

use ValeSaude\LaravelValueObjects\Casts\StringableValueObjectCast;
use ValeSaude\LaravelValueObjects\Email;
use ValeSaude\LaravelValueObjects\Tests\Dummies\DummyModel;

beforeEach(fn () => $this->sut = new StringableValueObjectCast(Email::class));

test('get returns value converted to given StringableValueObjectCast', function () {
    // Given
    $value = 'some@mail.com';

    // When
    $email = $this->sut->get(new DummyModel(), 'property', $value, []);

    // Then
    expect($email)->toBeInstanceOf(Email::class)
        ->toEqual($value);
});

test('get returns null when value is null', function () {
    // When
    $email = $this->sut->get(new DummyModel(), 'property', null, []);

    // Then
    expect($email)->toBeNull();
});

test('set returns given StringableValueObject converted to string', function () {
    // Given
    $email = new Email('some@mail.com');

    // When
    $value = $this->sut->set(new DummyModel(), 'property', $email, []);

    // Then
    expect($value)->toBe('some@mail.com');
});

test('set returns null when value is null', function () {
    // When
    $serialized = $this->sut->set(new DummyModel(), 'property', null, []);

    // Then
    expect($serialized)->toBeNull();
});