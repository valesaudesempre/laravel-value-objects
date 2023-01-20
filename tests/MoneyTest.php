<?php

use ValeSaude\LaravelValueObjects\Casts\MoneyCast;
use ValeSaude\LaravelValueObjects\Formatters\MoneyFormatter;
use ValeSaude\LaravelValueObjects\Money;
use function PHPUnit\Framework\once;

test('getCents returns the value in cents', function () {
    // Given
    $instance = new Money(12345);

    // When
    $cents = $instance->getCents();

    // Then
    expect($cents)->toEqual(12345);
});

test('toFloat returns the value in cents divided by 100, rounded half up with 2 decimal places', function () {
    // Given
    $instance = new Money(12345);

    // When
    $float = $instance->toFloat();

    // Then
    expect($float)->toEqual(123.45);
});

test('sum returns a new instance, containing the value summed by the given number', function () {
    // Given
    $instance = new Money(1000);

    // When
    $summed = $instance->sum(100);

    // Then
    expect($instance)->not->toBe($summed)
        ->and($instance->getCents())->toEqual(1000)
        ->and($summed->getCents())->toEqual(1100);
});

test('sum returns a new instance, containing the value subtracted by the given number', function () {
    // Given
    $instance = new Money(1000);

    // When
    $subtracted = $instance->subtract(100);

    // Then
    expect($instance)->not->toBe($subtracted)
        ->and($instance->getCents())->toEqual(1000)
        ->and($subtracted->getCents())->toEqual(900);
});

test('multiply returns a new instance, containing the value multiplied by the given multiplier', function () {
    // Given
    $instance = new Money(1000);

    // When
    $multipliedBy3 = $instance->multiply(2.5);

    // Then
    expect($instance)->not->toBe($multipliedBy3)
        ->and($instance->getCents())->toEqual(1000)
        ->and($multipliedBy3->getCents())->toEqual(2500);
});

test('multiply returns a new instance, containing the value dividev by the given divisor', function () {
    // Given
    $instance = new Money(1000);

    // When
    $dividedBy3 = $instance->divide(3);

    // Then
    expect($instance)->not->toBe($dividedBy3)
        ->and($instance->getCents())->toEqual(1000)
        ->and($dividedBy3->getCents())->toEqual(333);
});

test('percentage returns a new instance, containing the value representing the given percentage', function () {
    // Given
    $instance = new Money(1000);

    // When
    $percentage = $instance->percentage(15);

    // Then
    expect($instance)->not->toBe($percentage)
        ->and($instance->getCents())->toEqual(1000)
        ->and($percentage->getCents())->toEqual(150);
});

test('getFormatterClass returns MoneyFormatter', function () {
    // When
    $class = Money::zero()->getFormatterClass();

    // Then
    expect($class)->toEqual(MoneyFormatter::class);
});

test('castUsing returns an instance of MoneyCast', function () {
    // When
    $cast = Money::castUsing([]);

    // Then
    expect($cast)->toBeInstanceOf(MoneyCast::class);
});

test('zero returns an instance of Money with 0 as value', function () {
    // When
    $instance = Money::zero();

    // Then
    expect($instance->getCents())->toEqual(0);
});

test('fromFloat returns an instance of Money with given value multiplied by 100', function () {
    // When
    $instance = Money::fromFloat(123.45);

    // Then
    expect($instance->getCents())->toEqual(12345);
});

test('fromFormattedString calls MoneyFormatted fromFormattedString method and returns its return', function () {
    // Given
    mockInstance(MoneyFormatter::class)
        ->expects(once())
        ->method('fromFormattedString')
        ->willReturn(new Money(10000));
    // When
    $instance = Money::fromFormattedString('R$ 100,00');

    // Then
    expect($instance->getCents())->toEqual(10000);
});