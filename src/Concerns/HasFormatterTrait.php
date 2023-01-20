<?php

namespace ValeSaude\ValueObjects\Concerns;

use Illuminate\Container\Container;
use ValeSaude\ValueObjects\Formatters\Contracts\FormattableInterface;
use ValeSaude\ValueObjects\Formatters\Contracts\FormatterInterface;

/**
 * @mixin FormattableInterface
 */
trait HasFormatterTrait
{
    /**
     * @return class-string<FormatterInterface>
     */
    abstract public function getFormatterClass(): string;

    public function getFormatter(): FormatterInterface
    {
        return Container::getInstance()->get($this->getFormatterClass());
    }

    public function format(): string
    {
        return $this->getFormatter()->format($this);
    }
}