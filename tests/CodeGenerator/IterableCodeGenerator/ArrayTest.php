<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator\IterableCodeGenerator;

use steevanb\PhpAccessor\Tests\AccessorsCases\IterableAccessorsCases;

class ArrayTest extends AbstractIteratorTest
{
    protected function getPhpTypeHint(): string
    {
        return 'array';
    }

    protected function getClassToTest(): string
    {
        return IterableAccessorsCases::class;
    }
}
