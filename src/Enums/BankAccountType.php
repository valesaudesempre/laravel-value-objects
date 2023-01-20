<?php

namespace ValeSaude\LaravelValueObjects\Enums;

use Spatie\Enum\Laravel\Enum;
use ValeSaude\LaravelValueObjects\Concerns\ConvertsEnumValueToSlugTrait;

/**
 * @method static self SAVING()
 * @method static self CHECKING()
 */
final class BankAccountType extends Enum
{
    use ConvertsEnumValueToSlugTrait;
}
