<?php

use ValeSaude\LaravelValueObjects\Casts\DocumentCast;
use ValeSaude\LaravelValueObjects\Document;
use ValeSaude\LaravelValueObjects\Enums\DocumentType;
use ValeSaude\LaravelValueObjects\Tests\Dummies\DummyModel;

beforeEach(fn () => $this->sut = new DocumentCast());

test('get returns Document instance when both type and number properties are set', function () {
    // Given
    $attributes = ['property_type' => 'cpf', 'property_number' => '12345678909'];

    // When
    $document = $this->sut->get(new DummyModel(), 'property', null, $attributes);

    // Then
    expect($document)->toBeInstanceOf(Document::class)
        ->getNumber()->toEqual('12345678909')
        ->getType()->equals(DocumentType::CPF())->toBeTrue();
});

test('get returns null when both type and number properties are not set', function () {
    // Given
    $attributes = [];

    // When
    $document = $this->sut->get(new DummyModel(), 'property', null, $attributes);

    // Then
    expect($document)->toBeNull();
});

test('get returns null when both type and number property keys are present but empty', function () {
    // Given
    $attributes = ['property_type' => null, 'property_number' => null];

    // When
    $document = $this->sut->get(new DummyModel(), 'property', null, $attributes);

    // Then
    expect($document)->toBeNull();
});

test('get throws InvalidArgumentException when only one of the keys is set', function () {
    // Given
    $attributes = ['property_number' => '12345678909'];

    // When
    $this->sut->get(new DummyModel(), 'property', null, $attributes);
})->throws(InvalidArgumentException::class, 'Both property_number and property_type keys must be set or null.');

test('set returns an array containing the number and type properties', function () {
    // Given
    $document = new Document('12345678909', DocumentType::CPF());

    // When
    $attributes = $this->sut->set(new DummyModel(), 'property', $document, []);

    // Then
    expect($attributes)->toHaveKey('property_number', '12345678909')
        ->toHaveKey('property_type', DocumentType::CPF());
});

test('set returns an array containing null values when Document is null', function () {
    // When
    $attributes = $this->sut->set(new DummyModel(), 'property', null, []);

    // Then
    expect($attributes['property_number'])->toBeNull()
        ->and($attributes['property_type'])->toBeNull();
});

test('set throws InvalidArgumentException when given value is not a Document instance', function () {
    // Given
    $document = new stdClass();

    // When
    $this->sut->set(new DummyModel(), 'property', $document, []);
})->throws(InvalidArgumentException::class, 'The given value is not a Document instance.');