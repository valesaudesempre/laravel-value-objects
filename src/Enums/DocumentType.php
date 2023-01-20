<?php

namespace ValeSaude\ValueObjects\Enums;

use Spatie\Enum\Laravel\Enum;
use ValeSaude\ValueObjects\Concerns\ConvertsEnumValueToSlugTrait;

/**
 * @method static self CPF()
 * @method static self CNPJ()
 */
final class DocumentType extends Enum
{
    use ConvertsEnumValueToSlugTrait;
}
