<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Method;

use steevanb\PhpTypedArray\ObjectArray;

class MethodDefinitionArray extends ObjectArray
{
    public function __construct(array $values = [])
    {
        parent::__construct($values, MethodDefinition::class);
    }

    public function current(): ?MethodDefinition
    {
        return parent::current();
    }

    public function offsetGet($offset): MethodDefinition
    {
        return parent::offsetGet($offset);
    }
}
