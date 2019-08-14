<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\AccessorsCases;

use steevanb\PhpAccessor\Annotation\Accessors;

class IntAccessorsCases
{
    /** @Accessors(var="int") */
    private $property = 'foo';

    /** @Accessors(var="?int") */
    private $nullablePropertyPhpTypeHint;

    /** @Accessors(var="null|int") */
    private $nullablePropertyPhpDocFirst;

    /** @Accessors(var="int|null") */
    private $nullablePropertyPhpDocLast;

    /** @Accessors(var="int", getter=false) */
    private $propertySetterOnly = 'baz';

    /** @Accessors(var="int", setterMethod="renamedSetter") */
    private $propertyRenamedSetter = 'baz';

    /** @Accessors(var="int", setterParameter="renamedParameter") */
    private $propertySetterRenamedParameter = 'boz';

    /** @Accessors(var="int", setter=false) */
    private $propertyGetterOnly = 'bar';

    /** @Accessors(var="int", getterMethod="renamedGetter") */
    private $propertyRenamedGetter = 'bar';
}
