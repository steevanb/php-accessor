<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests;

use steevanb\PhpAccessor\Annotation\Accessors;

class IterableAccessorsCases
{
    /** @Accessors(var="iterable") */
    private $iterable = [];
}
