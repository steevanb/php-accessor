<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Property;

use steevanb\PhpTypedArray\ObjectArray\ObjectArray;

class PropertyDefinitionArray extends ObjectArray
{
    public function __construct(array $values = [])
    {
        parent::__construct($values, PropertyDefinition::class);
    }

    public function current(): ?PropertyDefinition
    {
        return parent::current();
    }

    public function offsetGet($offset): PropertyDefinition
    {
        return parent::offsetGet($offset);
    }
}
