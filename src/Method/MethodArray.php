<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Method;

use steevanb\PhpTypedArray\ObjectArray;

class MethodArray extends ObjectArray
{
    public function __construct(array $values = [])
    {
        parent::__construct($values, Method::class);
    }

    public function current(): ?Method
    {
        return parent::current();
    }

    public function offsetGet($offset): Method
    {
        return parent::offsetGet($offset);
    }
}
