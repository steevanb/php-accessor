<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator\SetterGetterCodeGenerator;

use steevanb\PhpAccessor\Tests\AccessorsCases\FloatAccessorsCases;

final class FloatTest extends AbstractScalarTest
{
    protected function getClassToTest(): string
    {
        return FloatAccessorsCases::class;
    }

    protected function getPhpTypeHint(): string
    {
        return 'float';
    }
}
