<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator\SetterGetterCodeGenerator;

use steevanb\PhpAccessor\Tests\AccessorsCases\DoubleAccessorsCases;

final class DoubleTypeTest extends AbstractScalarTypeTest
{
    protected function getClassToTest(): string
    {
        return DoubleAccessorsCases::class;
    }

    protected function getPhpTypeHint(): string
    {
        return 'float';
    }

    protected function getAnnotationType(): string
    {
        return 'double';
    }
}
