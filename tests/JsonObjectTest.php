<?php

use ValeSaude\LaravelValueObjects\Casts\JsonSerializableValueObjectCast;
use ValeSaude\LaravelValueObjects\JsonObject;

test('JsonObject can be serialized to JSON', function () {
    // Given
    $instance = new JsonObject([
        'key1' => 1,
        'key2' => 2,
    ]);

    // Then
    expect(json_encode($instance))->toBeJson()
        ->toEqual('{"key1":1,"key2":2}');
});

test('get correctly handles both existing and non existing keys', function () {
    // Given
    $instance = new JsonObject([
        'key1' => 1,
        'key2' => [
            'key21' => 'some value',
        ],
    ]);

    // Then
    expect($instance)->get('key1')->toBe(1)
        ->get('key2')->toBe(['key21' => 'some value'])
        ->get('key2.key21')->toBe('some value')
        ->get('key1.key11')->toBeNull()
        ->get('key2.key22')->toBeNull()
        ->get('key3', 'default value')->toBe('default value');
});

test('set returns a new JsonObject instance with given key set', function () {
    // Given
    $instance1 = new JsonObject([]);

    // When
    $instance2 = $instance1->set('key1', 1);
    $instance3 = $instance2->set('key1', 2);

    // Then
    expect($instance1->toArray())->toBe([])
        ->and($instance2->toArray())->toBe(['key1' => 1])
        ->and($instance3->toArray())->toBe(['key1' => 2]);
});

test('merge returns a new JsonObject instance with merged keys', function () {
    // Given
    $instance1 = new JsonObject([
        'key1' => 1,
        'key2' => [
            'key21' => 2,
        ],
        'key3' => 3,
    ]);

    // When
    $instance2 = $instance1->merge([
        'key1' => 2,
        'key2' => [
            'key22' => 4,
        ],
        'key4' => 5,
    ]);

    // Then
    expect($instance2)->equals($instance1)->toBeFalse()
        ->toArray()->toBe([
            'key1' => 2,
            'key2' => [
                'key22' => 4,
            ],
            'key3' => 3,
            'key4' => 5,
        ]);
});

test('only returns a new JsonObject instance containing only the given keys', function () {
    // Given
    $instance1 = new JsonObject([
        'key1' => 1,
        'key2' => 2,
    ]);

    // When
    $instance2 = $instance1->only(['key2']);

    // Then
    expect($instance2)->equals($instance1)->toBeFalse()
        ->toArray()->toBe(['key2' => 2]);
});

test('isEmpty returns true whether the JsonObject is empty', function () {
    // Given
    $instance = JsonObject::empty();

    // Then
    expect($instance)->isEmpty()->toBeTrue()
        ->and($instance->set('key1', 1))->isEmpty()->toBeFalse();
});

test('fromString converts a given JSON string to a JsonObject instance', function () {
    // Given
    $jsonString = '{"key1": 1}';

    // When
    $instance = JsonObject::fromString($jsonString);

    // Then
    expect($instance)->toArray()->toBe(['key1' => 1]);
});

test('fromArray returns a JsonObject instance containing given value', function () {
    // Given
    $instance = JsonObject::fromArray(['key1' => 1]);

    // Then
    expect($instance)->toArray()->toEqual(['key1' => 1]);
});

test('castUsing returns an JsonSerializableValueObjectCast', function () {
    expect(JsonObject::castUsing([]))->toBeInstanceOf(JsonSerializableValueObjectCast::class);
});

test('empty returns an empty JsonObject instance', function () {
    expect(JsonObject::empty())->isEmpty()->toBeTrue();
});