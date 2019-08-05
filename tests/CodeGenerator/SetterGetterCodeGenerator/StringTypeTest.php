<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator\SetterGetterCodeGenerator;

use PHPUnit\Framework\TestCase;

final class StringTypeTest extends TestCase
{
    use GetMethodsTrait;

    public function testStringPropertyMethods(): void
    {
        $methods = $this->getMethods('string', ['type' => 'string']);
        static::assertCount(2, $methods);

        static::assertSame('setString', $methods[0]->getName());
        static::assertSame($this->getStringSetterCode(), $methods[0]->getCode());

        static::assertSame('getString', $methods[1]->getName());
        static::assertSame($this->getStringGetterCode(), $methods[1]->getCode());
    }

    public function testNullableStringPropertyMethods(): void
    {
        $methods = $this->getMethods('nullableString', ['type' => '?string']);
        static::assertCount(2, $methods);

        static::assertSame('setNullableString', $methods[0]->getName());
        static::assertSame($this->getNullableStringSetterCode(), $methods[0]->getCode());

        static::assertSame('getNullableString', $methods[1]->getName());
        static::assertSame($this->getNullableStringGetterCode(), $methods[1]->getCode());
    }

    public function testStringSetterPropertyMethods(): void
    {
        $methods = $this->getMethods(
            'stringSetter',
            [
                'type' => 'string',
                'getter' => false,
                'setterMethod' => 'setFooString'
            ]
        );
        static::assertCount(1, $methods);

        static::assertSame('setFooString', $methods[0]->getName());
        static::assertSame(
            $this->getStringSetterCode('setFooString', 'stringSetter', 'stringSetter'),
            $methods[0]->getCode()
        );
    }

    public function testStringSetterPropertyParameterNameMethods(): void
    {
        $methods = $this->getMethods(
            'stringSetterParameterName',
            [
                'type' => 'string',
                'getter' => false,
                'setterParameter' => 'parameterName'
            ]
        );
        static::assertCount(1, $methods);

        static::assertSame('setStringSetterParameterName', $methods[0]->getName());
        static::assertSame(
            $this->getStringSetterCode('setStringSetterParameterName', 'stringSetterParameterName', 'parameterName'),
            $methods[0]->getCode()
        );
    }

    public function testStringGetterPropertyMethods(): void
    {
        $methods = $this->getMethods(
            'stringGetter',
            [
                'type' => 'string',
                'setter' => false,
                'getterMethod' => 'getFooString'
            ]
        );
        static::assertCount(1, $methods);

        static::assertSame('getFooString', $methods[0]->getName());
        static::assertSame($this->getStringGetterCode('getFooString', 'stringGetter'), $methods[0]->getCode());
    }

    private function getStringSetterCode(
        string $method = 'setString',
        string $property = 'string',
        string $parameter = 'string'
    ): string {
        return '    public function ' . $method . '(string $' . $parameter . '): self
    {
        $this->' . $property . ' = $' . $parameter . ';

        return $this;
    }';
    }

    private function getStringGetterCode(string $method = 'getString', string $property = 'string'): string
    {
        return '    public function ' . $method . '(): string
    {
        return $this->' . $property . ';
    }';
    }

    private function getNullableStringSetterCode(): string
    {
        return '    public function setNullableString(?string $nullableString): self
    {
        $this->nullableString = $nullableString;

        return $this;
    }';
    }

    private function getNullableStringGetterCode(): string
    {
        return '    public function getNullableString(): ?string
    {
        return $this->nullableString;
    }';
    }
}
