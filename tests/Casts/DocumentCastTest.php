<?php

use ValeSaude\LaravelValueObjects\Casts\DocumentCast;
use ValeSaude\LaravelValueObjects\Document;
use ValeSaude\LaravelValueObjects\Enums\DocumentType;
use ValeSaude\LaravelValueObjects\Tests\Dummies\DummyModel;

beforeEach(fn () => $this->sut = new DocumentCast());

test('get returns Document instance when both document_type and document_number are set', function () {
    // Given
    $attributes = ['document_type' => 'cpf', 'document_number' => '38253459556'];

    // When
    $document = $this->sut->get(new DummyModel(), 'property', null, $attributes);

    // Then
    expect($document)->toBeInstanceOf(Document::class)
        ->getNumber()->toEqual('38253459556')
        ->getType()->equals(DocumentType::CPF())->toBeTrue();
});

test('get returns null when both document_type and document_number are not set', function () {
    // Given
    $attributes = [];

    // When
    $document = $this->sut->get(new DummyModel(), 'property', null, $attributes);

    // Then
    expect($document)->toBeNull();
});

test('get returns null when both document_type and document_number keys are present but empty', function () {
    // Given
    $attributes = ['document_type' => null, 'document_number' => null];

    // When
    $document = $this->sut->get(new DummyModel(), 'property', null, $attributes);

    // Then
    expect($document)->toBeNull();
});

test('get throws InvalidArgumentException when only one of the keys is set', function () {
    // Given
    $attributes = ['document_number' => '38253459556'];

    // When
    $this->sut->get(new DummyModel(), 'property', null, $attributes);
})->throws(InvalidArgumentException::class, 'Both document_number and document_type keys must be set or null.');

test('set returns an array containing the document_number and document_type', function () {
    // Given
    $document = new Document('38253459556', DocumentType::CPF());

    // When
    $attributes = $this->sut->set(new DummyModel(), 'property', $document, []);

    // Then
    expect($attributes)->toHaveKey('document_number', '38253459556')
        ->toHaveKey('document_type', DocumentType::CPF());
});

test('set returns an array containing null values when Document is null', function () {
    // When
    $attributes = $this->sut->set(new DummyModel(), 'property', null, []);

    // Then
    expect($attributes['document_number'])->toBeNull()
        ->and($attributes['document_type'])->toBeNull();
});

test('set throws InvalidArgumentException when given value is not a Document instance', function () {
    // Given
    $document = new stdClass();

    // When
    $attributes = $this->sut->set(new DummyModel(), 'property', $document, []);
})->throws(InvalidArgumentException::class, 'The given value is not a Document instance.');