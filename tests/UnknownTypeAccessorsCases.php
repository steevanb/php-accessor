<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests;

use steevanb\PhpAccessor\Annotation\Accessors;

class UnknownTypeAccessorsCases
{
    /** @Accessors() */
    private $unknownType = 'unknownType';
}
