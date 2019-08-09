<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator\SetterGetterCodeGenerator\Behavior;

use PHPUnit\Framework\TestCase;
use steevanb\PhpAccessor\Method\MethodDefinition;
use steevanb\PhpAccessor\Method\MethodDefinitionArray;

trait AssertAccessorsTrait
{
    protected static function assertMethod(string $name, string $code, MethodDefinition $methodDefinition): void
    {
        TestCase::assertSame($name, $methodDefinition->getName());
        TestCase::assertSame($code, $methodDefinition->getCode());
    }

    protected static function assertAccessors(
        MethodDefinitionArray $methods,
        string $setterCode,
        string $getterCode
    ): void {
        TestCase::assertCount(2, $methods);

        static::assertMethod('setProperty', $setterCode, $methods[0]);
        static::assertMethod('setProperty', $getterCode, $methods[1]);
    }
}
