<?php

namespace ValeSaude\ValueObjects;

use Illuminate\Container\Container;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use ValeSaude\ValueObjects\Casts\DocumentCast;
use ValeSaude\ValueObjects\Enums\DocumentType;
use ValeSaude\ValueObjects\Formatters\Contracts\FormattableInterface;
use ValeSaude\ValueObjects\Validators\CNPJValidator;
use ValeSaude\ValueObjects\Validators\Contracts\ValidatorInterface;
use ValeSaude\ValueObjects\Validators\CPFValidator;

class Document extends AbstractValueObject implements Castable, FormattableInterface
{
    private string $number;
    private DocumentType $type;

    public function __construct(string $number, DocumentType $type)
    {
        $validator = $this->resolveValidator($type);

        if (!$validator->validate($number)) {
            throw new InvalidArgumentException("The provided value is not a valid {$type->label}.");
        }

        $this->number = $validator->sanitize($number);
        $this->type = $type;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getType(): DocumentType
    {
        return $this->type;
    }

    public function format(): string
    {
        $chars = str_split($this->number);

        if ($this->type->equals(DocumentType::CPF())) {
            return sprintf('%s%s%s.%s%s%s.%s%s%s-%s%s', ...$chars);
        }

        return sprintf('%s%s.%s%s%s.%s%s%s/%s%s%s%s-%s%s', ...$chars);
    }

    private function resolveValidator(DocumentType $type): ValidatorInterface
    {
        if ($type->equals(DocumentType::CNPJ())) {
            return Container::getInstance()->get(CNPJValidator::class);
        }

        return Container::getInstance()->get(CPFValidator::class);
    }

    /**
     * @param array<array-key, mixed> $arguments
     */
    public static function castUsing(array $arguments): CastsAttributes
    {
        return new DocumentCast();
    }
}
