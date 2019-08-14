<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator\SetterGetterCodeGenerator;

use steevanb\PhpAccessor\Tests\AccessorsCases\StringAccessorsCases;

final class StringTypeTest extends AbstractScalarTypeTest
{
    protected function getClassToTest(): string
    {
        return StringAccessorsCases::class;
    }

    protected function getPhpTypeHint(): string
    {
        return 'string';
    }
}
