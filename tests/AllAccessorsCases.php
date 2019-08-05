<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests;

use steevanb\PhpAccessor\Annotation\Accessors;

class AllAccessorsCases
{
    /** @Accessors() */
    public $unknownType = 'unknownType';

    /** @Accessors(var="string") */
    public $string = 'foo';

    /** @Accessors(var="?string") */
    public $nullableString;

    /** @Accessors(var="string", setter=false, getterMethod="getFooString") */
    public $stringGetter = 'bar';

    /** @Accessors(var="string", getter=false, setterMethod="setFooString") */
    public $stringSetter = 'baz';

    /** @Accessors(var="string", getter=false, setterParameter="parameterName") */
    public $stringSetterParameterName = 'boz';

    /** @Accessors(var="int") */
    public $int = 10;

    /** @Accessors(var="?int") */
    public $nullableInt;

    /** @Accessors(var="int", setter=false, getterMethod="getFooInt") */
    public $intGetter = 'bar';

    /** @Accessors(var="int", getter=false, setterMethod="setFooInt") */
    public $intSetter = 'baz';

    /** @Accessors(var="int", getter=false, setterParameter="parameterName") */
    public $intSetterParameterName = 'boz';

    /** @Accessors(var="integer") */
    public $integer = 11;

    /** @Accessors(var="float") */
    public $float = 10.10;

    /** @Accessors(var="double") */
    public $double = 10.10;

    /** @Accessors(var="array") */
    public $array = [];

    /** @var ?string */
    public $notAnAccessor;

    /** @Accessors(var="iterable") */
    public $iterable = [];

    /** @Accessors(var="\DateTime") */
    public $dateTime;

    /** @Accessors(var="?steevanb\PhpAccessor\Tests\AllAccessorsCases") */
    public $allAccessorsCases;

    public function __construct()
    {
        $this->dateTime = new \DateTime();
    }
}
