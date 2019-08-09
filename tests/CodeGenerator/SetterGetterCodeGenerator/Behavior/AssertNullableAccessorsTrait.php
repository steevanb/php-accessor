<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator\SetterGetterCodeGenerator\Behavior;

use steevanb\PhpAccessor\Method\MethodDefinitionArray;

trait AssertNullableAccessorsTrait
{
    protected static function assertNullableAccessors(
        MethodDefinitionArray $methods,
        string $setterMethod,
        string $getterMethod
    ): void {
        static::assertCount(2, $methods);

        static::assertSame('setNullableProperty', $methods[0]->getName());
        static::assertSame($setterMethod, $methods[0]->getCode());

        static::assertSame('getNullableProperty', $methods[1]->getName());
        static::assertSame($getterMethod, $methods[1]->getCode());
    }
}
