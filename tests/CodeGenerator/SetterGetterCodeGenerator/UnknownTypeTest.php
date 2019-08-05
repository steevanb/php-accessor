<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator\SetterGetterCodeGenerator;

use PHPUnit\Framework\TestCase;

final class StringTest extends TestCase
{
    use GetMethodsTrait;

    public function testUnknownTypePropertyMethods(): void
    {
        $methods = $this->getMethods('unknownType', ['type' => null]);
        static::assertCount(2, $methods);

        static::assertSame('setUnknownType', $methods[0]->getName());
        static::assertSame($this->getUnknownTypeSetterCode(), $methods[0]->getCode());

        static::assertSame('getUnknownType', $methods[1]->getName());
        static::assertSame($this->getUnknownTypeGetterCode(), $methods[1]->getCode());
    }

    private function getUnknownTypeSetterCode(): string
    {
        return '    public function setUnknownType($unknownType): self
    {
        $this->unknownType = $unknownType;

        return $this;
    }';
    }

    private function getUnknownTypeGetterCode(): string
    {
        return '    public function getUnknownType()
    {
        return $this->unknownType;
    }';
    }
}
