<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests;

use steevanb\PhpAccessor\Annotation\Accessors;

class DoubleAccessorsCases
{
    /** @Accessors(var="double") */
    private $property = [];

    /** @Accessors(var="?double") */
    private $nullableProperty = [];

    /** @Accessors(var="double", setterMethod="setFooProperty", getter=false) */
    private $setterOnlyProperty = [];

    /** @Accessors(var="double", setterParameter="foo") */
    private $setterParamenterNameProperty = [];

    /** @Accessors(var="double", setter=false, getterMethod="getFooProperty") */
    private $getterOnlyProperty = [];
}
