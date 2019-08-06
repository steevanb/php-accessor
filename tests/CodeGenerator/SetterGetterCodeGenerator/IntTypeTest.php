<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator\SetterGetterCodeGenerator;

use PHPUnit\Framework\TestCase;

final class IntTypeTest extends TestCase
{
    use GetMethodsTrait;

    public function testIntPropertyMethods(): void
    {
        $methods = $this->getMethods('int', ['type' => 'int']);
        static::assertCount(2, $methods);

        static::assertSame('setInt', $methods[0]->getName());
        static::assertSame($this->getIntSetterCode(), $methods[0]->getCode());

        static::assertSame('getInt', $methods[1]->getName());
        static::assertSame($this->getIntGetterCode(), $methods[1]->getCode());
    }

    public function testNullableIntPropertyMethods(): void
    {
        $methods = $this->getMethods('nullableInt', ['type' => '?int']);
        static::assertCount(2, $methods);

        static::assertSame('setNullableInt', $methods[0]->getName());
        static::assertSame($this->getNullableIntSetterCode(), $methods[0]->getCode());

        static::assertSame('getNullableInt', $methods[1]->getName());
        static::assertSame($this->getNullableIntGetterCode(), $methods[1]->getCode());
    }

    public function testIntSetterPropertyMethods(): void
    {
        $methods = $this->getMethods(
            'intSetter',
            [
                'type' => 'int',
                'getter' => false,
                'setterMethod' => 'setFooInt'
            ]
        );
        static::assertCount(1, $methods);

        static::assertSame('setFooInt', $methods[0]->getName());
        static::assertSame(
            $this->getIntSetterCode('setFooInt', 'intSetter', 'intSetter'),
            $methods[0]->getCode()
        );
    }

    public function testIntSetterPropertyParameterNameMethods(): void
    {
        $methods = $this->getMethods(
            'intSetterParameterName',
            [
                'type' => 'int',
                'getter' => false,
                'setterParameter' => 'parameterName'
            ]
        );
        static::assertCount(1, $methods);

        static::assertSame('setIntSetterParameterName', $methods[0]->getName());
        static::assertSame(
            $this->getIntSetterCode('setIntSetterParameterName', 'intSetterParameterName', 'parameterName'),
            $methods[0]->getCode()
        );
    }

    public function testIntGetterPropertyMethods(): void
    {
        $methods = $this->getMethods(
            'intGetter',
            [
                'type' => 'int',
                'setter' => false,
                'getterMethod' => 'getFooInt'
            ]
        );
        static::assertCount(1, $methods);

        static::assertSame('getFooInt', $methods[0]->getName());
        static::assertSame($this->getIntGetterCode('getFooInt', 'intGetter'), $methods[0]->getCode());
    }

    private function getIntSetterCode(
        string $method = 'setInt',
        string $property = 'int',
        string $parameter = 'int'
    ): string {
        return '    public function ' . $method . '(int $' . $parameter . '): self
    {
        $this->' . $property . ' = $' . $parameter . ';

        return $this;
    }';
    }

    private function getIntGetterCode(string $method = 'getInt', string $property = 'int'): string
    {
        return '    public function ' . $method . '(): int
    {
        return $this->' . $property . ';
    }';
    }

    private function getNullableIntSetterCode(): string
    {
        return '    public function setNullableInt(?int $nullableInt): self
    {
        $this->nullableInt = $nullableInt;

        return $this;
    }';
    }

    private function getNullableIntGetterCode(): string
    {
        return '    public function getNullableInt(): ?int
    {
        return $this->nullableInt;
    }';
    }
}
