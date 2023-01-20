<?php

namespace ValeSaude\LaravelValueObjects\Enums;

use Spatie\Enum\Laravel\Enum;
use ValeSaude\LaravelValueObjects\Concerns\ConvertsEnumValueToSlugTrait;

/**
 * @method static self CPF()
 * @method static self CNPJ()
 */
final class DocumentType extends Enum
{
    use ConvertsEnumValueToSlugTrait;
}
