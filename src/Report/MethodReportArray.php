<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Report;

use steevanb\PhpTypedArray\ObjectArray\ObjectArray;

class MethodReportArray extends ObjectArray
{
    public function __construct(array $values = [])
    {
        parent::__construct($values, MethodReport::class);
    }

    public function current(): ?MethodReport
    {
        return parent::current();
    }

    public function offsetGet($offset): MethodReport
    {
        return parent::offsetGet($offset);
    }
}
