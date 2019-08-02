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

    /** @Accessors(setter=false, getterMethod="getFooString") */
    public $stringGetter = 'bar';

    /** @Accessors(getter=false, setterMethod="setFooString") */
    public $stringSetter = 'baz';

    /** @Accessors(var="int") */
    public $int = 10;

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
