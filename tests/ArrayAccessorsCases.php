<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests;

use steevanb\PhpAccessor\Annotation\Accessors;

class ArrayAccessorsCases
{
    /** @Accessors(var="array") */
    private $property = [];

    /** @Accessors(var="?array") */
    private $nullableProperty = [];

    /** @Accessors(var="array", setterMethod="setFooProperty", getter=false) */
    private $setterOnlyProperty = [];

    /** @Accessors(var="array", setterParameter="foo") */
    private $setterParamenterNameProperty = [];

    /** @Accessors(var="array", setter=false, getterMethod="getFooProperty") */
    private $getterOnlyProperty = [];
}
