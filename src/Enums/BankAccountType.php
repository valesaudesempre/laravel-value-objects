<?php

namespace ValeSaude\ValueObjects\Enums;

use Spatie\Enum\Laravel\Enum;
use ValeSaude\ValueObjects\Concerns\ConvertsEnumValueToSlugTrait;

/**
 * @method static self SAVING()
 * @method static self CHECKING()
 */
final class BankAccountType extends Enum
{
    use ConvertsEnumValueToSlugTrait;
}
