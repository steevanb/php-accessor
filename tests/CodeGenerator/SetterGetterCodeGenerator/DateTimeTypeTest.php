<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator\SetterGetterCodeGenerator;

use steevanb\PhpAccessor\Tests\AccessorsCases\DateTimeAccessorsCases;

final class DateTimeTypeTest extends AbstractScalarTypeTest
{
    protected function getClassToTest(): string
    {
        return DateTimeAccessorsCases::class;
    }

    protected function getPhpTypeHint(): string
    {
        return '\\' . \DateTime::class;
    }
}
