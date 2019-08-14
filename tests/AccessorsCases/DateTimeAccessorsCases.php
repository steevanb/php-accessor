<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\AccessorsCases;

use steevanb\PhpAccessor\Annotation\Accessors;

class DateTimeAccessorsCases
{
    /** @Accessors(var="\DateTime") */
    private $property = 'foo';

    /** @Accessors(var="?\DateTime") */
    private $nullablePropertyPhpTypeHint;

    /** @Accessors(var="null|\DateTime") */
    private $nullablePropertyPhpDocFirst;

    /** @Accessors(var="\DateTime|null") */
    private $nullablePropertyPhpDocLast;

    /** @Accessors(var="\DateTime", getter=false) */
    private $propertySetterOnly = 'baz';

    /** @Accessors(var="\DateTime", setterMethod="renamedSetter") */
    private $propertyRenamedSetter = 'baz';

    /** @Accessors(var="\DateTime", setterParameter="renamedParameter") */
    private $propertySetterRenamedParameter = 'boz';

    /** @Accessors(var="\DateTime", setter=false) */
    private $propertyGetterOnly = 'bar';

    /** @Accessors(var="\DateTime", getterMethod="renamedGetter") */
    private $propertyRenamedGetter = 'bar';
}
