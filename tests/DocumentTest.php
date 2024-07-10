<?php

use ValeSaude\LaravelValueObjects\Document;
use ValeSaude\LaravelValueObjects\Enums\DocumentType;

test('guess correctly guesses both a CPF and a CNPJ documents', function (string $input, DocumentType $expectedType) {
    // When
    $document = Document::guess($input);

    // Then
    expect($document)->getType()->equals($expectedType)->toBeTrue();
})->with([
    'masked cpf' => [
        '123.456.789-09',
        DocumentType::CPF(),
    ],
    'unmasked cpf' => [
        '12345678909',
        DocumentType::CPF(),
    ],
    'masked cnpj' => [
        '12.345.678/0001-95',
        DocumentType::CNPJ(),
    ],
    'unmasked cnpj' => [
        '12345678000195',
        DocumentType::CNPJ(),
    ],
]);

test('guess throws when the given input is not a valid document', function () {
    Document::guess('invalid input');
})->throws(InvalidArgumentException::class, 'The provided value is not a valid document.');