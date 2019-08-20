<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator\SetterGetterCodeGenerator;

use steevanb\PhpAccessor\Tests\AccessorsCases\IntegerAccessorsCases;

final class IntegerTest extends AbstractScalarTest
{
    protected function getClassToTest(): string
    {
        return IntegerAccessorsCases::class;
    }

    protected function getPhpTypeHint(): string
    {
        return 'int';
    }

    protected function getAnnotationType(): string
    {
        return 'integer';
    }
}
