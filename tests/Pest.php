<?php

use Illuminate\Container\Container;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @template T of class-string
 *
 * @param T $abstract
 *
 * @return MockObject&T
 */
function mock(string $abstract): MockObject
{
    return test()->createMock($abstract);
}

/**
 * @template T of class-string
 *
 * @param T $abstract
 *
 * @return MockObject&T
 */
function mockInstance(string $abstract): MockObject
{
    $mock = mock($abstract);

    return tap(
        $mock,
        static fn (MockObject $mock) => Container::getInstance()
            ->bind($abstract, static fn () => $mock)
    );
}