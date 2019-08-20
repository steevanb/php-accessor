<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator\SetterGetterCodeGenerator;

use steevanb\PhpAccessor\Tests\AccessorsCases\IntAccessorsCases;

final class IntTest extends AbstractScalarTest
{
    protected function getClassToTest(): string
    {
        return IntAccessorsCases::class;
    }

    protected function getPhpTypeHint(): string
    {
        return 'int';
    }
}
