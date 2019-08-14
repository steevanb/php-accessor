<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\AccessorsCases;

use steevanb\PhpAccessor\Annotation\Accessors;

class IntegerAccessorsCases
{
    /** @Accessors(var="integer") */
    private $property = 'foo';

    /** @Accessors(var="?integer") */
    private $nullablePropertyPhpTypeHint;

    /** @Accessors(var="null|integer") */
    private $nullablePropertyPhpDocFirst;

    /** @Accessors(var="integer|null") */
    private $nullablePropertyPhpDocLast;

    /** @Accessors(var="integer", getter=false) */
    private $propertySetterOnly = 'baz';

    /** @Accessors(var="integer", setterMethod="renamedSetter") */
    private $propertyRenamedSetter = 'baz';

    /** @Accessors(var="integer", setterParameter="renamedParameter") */
    private $propertySetterRenamedParameter = 'boz';

    /** @Accessors(var="integer", setter=false) */
    private $propertyGetterOnly = 'bar';

    /** @Accessors(var="integer", getterMethod="renamedGetter") */
    private $propertyRenamedGetter = 'bar';
}
