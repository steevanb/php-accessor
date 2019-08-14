<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\AccessorsCases;

use steevanb\PhpAccessor\Annotation\Accessors;

class DoubleAccessorsCases
{
    /** @Accessors(var="double") */
    private $property = 'foo';

    /** @Accessors(var="?double") */
    private $nullablePropertyPhpTypeHint;

    /** @Accessors(var="null|double") */
    private $nullablePropertyPhpDocFirst;

    /** @Accessors(var="double|null") */
    private $nullablePropertyPhpDocLast;

    /** @Accessors(var="double", getter=false) */
    private $propertySetterOnly = 'baz';

    /** @Accessors(var="double", setterMethod="renamedSetter") */
    private $propertyRenamedSetter = 'baz';

    /** @Accessors(var="double", setterParameter="renamedParameter") */
    private $propertySetterRenamedParameter = 'boz';

    /** @Accessors(var="double", setter=false) */
    private $propertyGetterOnly = 'bar';

    /** @Accessors(var="double", getterMethod="renamedGetter") */
    private $propertyRenamedGetter = 'bar';
}
