<?php

namespace ValeSaude\LaravelValueObjects;

use Illuminate\Container\Container;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use ValeSaude\LaravelValueObjects\Casts\DocumentCast;
use ValeSaude\LaravelValueObjects\Enums\DocumentType;
use ValeSaude\LaravelValueObjects\Formatters\Contracts\FormattableInterface;
use ValeSaude\LaravelValueObjects\Generators\CPFGenerator;
use ValeSaude\LaravelValueObjects\Validators\CNPJValidator;
use ValeSaude\LaravelValueObjects\Validators\Contracts\ValidatorInterface;
use ValeSaude\LaravelValueObjects\Validators\CPFValidator;

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

    public static function CPF(string $cpf): self
    {
        return new self($cpf, DocumentType::CPF());
    }

    public static function CNPJ(string $cnpj): self
    {
        return new self($cnpj, DocumentType::CNPJ());
    }

    public static function guess(string $document): self
    {
        /** @var string $document */
        $document = preg_replace('/\D/', '', $document);

        if (strlen($document) === 11) {
            return new self($document, DocumentType::CPF());
        }

        if (strlen($document) === 14) {
            return new self($document, DocumentType::CNPJ());
        }

        throw new InvalidArgumentException('The provided value is not a valid document.');
    }

    public static function generateCPF(): self
    {
        $generator = Container::getInstance()->get(CPFGenerator::class);

        return new self($generator->generate(), DocumentType::CPF());
    }
}
