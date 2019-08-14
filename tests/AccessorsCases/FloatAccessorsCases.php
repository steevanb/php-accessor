<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\AccessorsCases;

use steevanb\PhpAccessor\Annotation\Accessors;

class FloatAccessorsCases
{
    /** @Accessors(var="float") */
    private $property = 'foo';

    /** @Accessors(var="?float") */
    private $nullablePropertyPhpTypeHint;

    /** @Accessors(var="null|float") */
    private $nullablePropertyPhpDocFirst;

    /** @Accessors(var="float|null") */
    private $nullablePropertyPhpDocLast;

    /** @Accessors(var="float", getter=false) */
    private $propertySetterOnly = 'baz';

    /** @Accessors(var="float", setterMethod="renamedSetter") */
    private $propertyRenamedSetter = 'baz';

    /** @Accessors(var="float", setterParameter="renamedParameter") */
    private $propertySetterRenamedParameter = 'boz';

    /** @Accessors(var="float", setter=false) */
    private $propertyGetterOnly = 'bar';

    /** @Accessors(var="float", getterMethod="renamedGetter") */
    private $propertyRenamedGetter = 'bar';
}
