<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests;

use steevanb\PhpAccessor\Annotation\Accessors;

class StringAccessorsCases
{
    /** @Accessors(var="string") */
    private $property = 'foo';

    /** @Accessors(var="?string") */
    private $nullableProperty;

    /** @Accessors(var="string", getter=false) */
    private $propertySetterOnly = 'baz';

    /** @Accessors(var="string", setterMethod="setFooProperty") */
    private $propertyRenamedSetter = 'baz';

    /** @Accessors(var="string", setterParameter="parameterName") */
    private $propertySetterParameterName = 'boz';

    /** @Accessors(var="string", setter=false) */
    private $propertyGetterOnly = 'bar';

    /** @Accessors(var="string", getterMethod="getFooProperty") */
    private $propertyRenamedGetter = 'bar';
}
