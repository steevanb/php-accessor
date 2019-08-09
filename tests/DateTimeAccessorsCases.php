<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests;

use steevanb\PhpAccessor\Annotation\Accessors;

class DateTimeAccessorsCases
{
    /** @Accessors(var="\DateTime") */
    private $dateTime;

    public function __construct()
    {
        $this->dateTime = new \DateTime();
    }
}
