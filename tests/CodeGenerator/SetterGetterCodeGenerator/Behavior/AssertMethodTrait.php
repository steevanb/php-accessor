<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator\SetterGetterCodeGenerator\Behavior;

use PHPUnit\Framework\TestCase;
use steevanb\PhpAccessor\Method\MethodDefinition;

trait AssertMethodTrait
{
    protected static function assertMethod(string $name, string $code, MethodDefinition $methodDefinition): void
    {
        TestCase::assertSame($name, $methodDefinition->getName());
        TestCase::assertSame($code, $methodDefinition->getCode());
    }
}
