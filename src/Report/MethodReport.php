<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Report;

use steevanb\PhpAccessor\Method\MethodDefinition;

class MethodReport
{
    public const WRITTEN_NO = 1;
    public const WRITTEN_NO_ALREADY_EXIST = 2;
    public const WRITTEN_YES = 3;

    /** @var string */
    protected $name;

    /** @var MethodDefinition */
    protected $definition;

    /** @var int */
    protected $written = self::WRITTEN_NO;

    public function __construct(string $name, MethodDefinition $definition)
    {
        $this->name = $name;
        $this->definition = $definition;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDefinition(): MethodDefinition
    {
        return $this->definition;
    }

    public function setWritten(int $written): self
    {
        $this->written = $written;

        return $this;
    }

    public function getWritten(): int
    {
        return $this->written;
    }
}
