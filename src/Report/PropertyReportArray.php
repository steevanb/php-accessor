<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Report;

use steevanb\PhpTypedArray\ObjectArray\ObjectArray;

class PropertyReportArray extends ObjectArray
{
    public function __construct(array $values = [])
    {
        parent::__construct($values, PropertyReport::class);
    }

    public function current(): ?PropertyReport
    {
        return parent::current();
    }

    public function offsetGet($offset): PropertyReport
    {
        return parent::offsetGet($offset);
    }
}
