<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests;

use steevanb\PhpAccessor\Annotation\Accessors;

class IntAccessorsCases
{
    /** @Accessors(var="int") */
    private $int = 10;

    /** @Accessors(var="?int") */
    private $nullableInt;

    /** @Accessors(var="int", setter=false, getterMethod="getFooInt") */
    private $intGetter = 'bar';

    /** @Accessors(var="int", getter=false, setterMethod="setFooInt") */
    private $intSetter = 'baz';

    /** @Accessors(var="int", getter=false, setterParameter="parameterName") */
    private $intSetterParameterName = 'boz';
}
