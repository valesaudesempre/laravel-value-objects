<?php

use ValeSaude\ValueObjects\Formatters\MoneyFormatter;
use ValeSaude\ValueObjects\Money;

beforeEach(fn () => $this->sut = new MoneyFormatter());

test('format returns a formatted money representation', function () {
    // Given
    $money = new Money(12345);

    // When
    $formatted = $this->sut->format($money);

    // Then
    expect($formatted)->toEqual('123,45');
});

test('fromFormattedString returns a Money instance with corresponding value', function (string $formattedString, int $value) {
    // When
    $money = $this->sut->fromFormattedString($formattedString);

    // Then
    expect($money->getCents())->toEqual($value);
})->with([
    ['123,45', 12345],
    ['123', 12300],
    ['1.234,00', 123400],
    ['1.234', 123400],
    ['R$ 123,45', 12345],
]);