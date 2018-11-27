<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Method;

class Method
{
    /** @var string */
    protected $name;

    /** @var ?string */
    protected $code;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }
}
