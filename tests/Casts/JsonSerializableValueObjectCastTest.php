<?php

use ValeSaude\LaravelValueObjects\Casts\JsonSerializableValueObjectCast;
use ValeSaude\LaravelValueObjects\JsonObject;
use ValeSaude\LaravelValueObjects\Tests\Dummies\DummyModel;

beforeEach(fn () => $this->sut = new JsonSerializableValueObjectCast(JsonObject::class));

test('get returns value converted to given JsonSerializableValueObject', function () {
    // Given
    $value = '{"key": "value"}';

    // When
    $object = $this->sut->get(new DummyModel(), 'property', $value, []);

    // Then
    expect($object)->toBeInstanceOf(JsonObject::class)
        ->toArray()->toEqual(['key' => 'value']);
});

test('get returns null when value is null', function () {
    // When
    $object = $this->sut->get(new DummyModel(), 'property', null, []);

    // Then
    expect($object)->toBeNull();
});

test('set returns given JsonSerializableValueObject serialized into string', function () {
    // Given
    $object = new JsonObject(['key' => 'value']);

    // When
    $value = $this->sut->set(new DummyModel(), 'property', $object, []);

    // Then
    expect($value)->toBeJson()
        ->toEqual('{"key":"value"}');
});

test('set returns null when value is null', function () {
    // When
    $value = $this->sut->set(new DummyModel(), 'property', null, []);

    // Then
    expect($value)->toBeNull();
});