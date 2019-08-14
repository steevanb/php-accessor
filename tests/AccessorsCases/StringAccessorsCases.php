<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\AccessorsCases;

use steevanb\PhpAccessor\Annotation\Accessors;

class StringAccessorsCases
{
    /** @Accessors(var="string") */
    private $property = 'foo';

    /** @Accessors(var="?string") */
    private $nullablePropertyPhpTypeHint;

    /** @Accessors(var="null|string") */
    private $nullablePropertyPhpDocFirst;

    /** @Accessors(var="string|null") */
    private $nullablePropertyPhpDocLast;

    /** @Accessors(var="string", getter=false) */
    private $propertySetterOnly = 'baz';

    /** @Accessors(var="string", setterMethod="renamedSetter") */
    private $propertyRenamedSetter = 'baz';

    /** @Accessors(var="string", setterParameter="renamedParameter") */
    private $propertySetterRenamedParameter = 'boz';

    /** @Accessors(var="string", setter=false) */
    private $propertyGetterOnly = 'bar';

    /** @Accessors(var="string", getterMethod="renamedGetter") */
    private $propertyRenamedGetter = 'bar';
}
