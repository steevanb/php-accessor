<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator\SetterGetterCodeGenerator;

use PHPUnit\Framework\TestCase;
use steevanb\PhpAccessor\Tests\DoubleAccessorsCases;

final class DoubleTypeTest extends TestCase
{
    use GetMethodsTrait;

    public function testAccessors(): void
    {
        $methods = $this->getMethods(DoubleAccessorsCases::class, 'property', ['type' => 'double']);
        static::assertCount(2, $methods);

        static::assertSame('setProperty', $methods[0]->getName());
        static::assertSame($this->getSetterCode(), $methods[0]->getCode());

        static::assertSame('getProperty', $methods[1]->getName());
        static::assertSame($this->getGetterCode(), $methods[1]->getCode());
    }

    public function testNullableAccessors(): void
    {
        $methods = $this->getMethods(DoubleAccessorsCases::class, 'nullableProperty', ['type' => '?double']);
        static::assertCount(2, $methods);

        static::assertSame('setNullableProperty', $methods[0]->getName());
        static::assertSame($this->getNullableSetterCode(), $methods[0]->getCode());

        static::assertSame('getNullableProperty', $methods[1]->getName());
        static::assertSame($this->getNullableGetterCode(), $methods[1]->getCode());
    }

    public function testSetterOnly(): void
    {
        $methods = $this->getMethods(
            DoubleAccessorsCases::class,
            'setterOnlyProperty',
            [
                'type' => 'double',
                'getter' => false,
                'setterMethod' => 'setFooProperty'
            ]
        );
        static::assertCount(1, $methods);

        static::assertSame('setFooProperty', $methods[0]->getName());
        static::assertSame(
            $this->getSetterCode('setFooProperty', 'setterOnlyProperty', 'setterOnlyProperty'),
            $methods[0]->getCode()
        );
    }

    public function testSetterParameterName(): void
    {
        $methods = $this->getMethods(
            DoubleAccessorsCases::class,
            'setterParamenterNameProperty',
            [
                'type' => 'double',
                'setterParameter' => 'fooParameter'
            ]
        );

        static::assertSame('setSetterParamenterNameProperty', $methods[0]->getName());
        static::assertSame(
            $this->getSetterCode('setSetterParamenterNameProperty', 'setterParamenterNameProperty', 'fooParameter'),
            $methods[0]->getCode()
        );
    }

    public function testGetterOnly(): void
    {
        $methods = $this->getMethods(
            DoubleAccessorsCases::class,
            'getterOnlyProperty',
            [
                'type' => 'double',
                'setter' => false,
                'getterMethod' => 'getFooProperty'
            ]
        );
        static::assertCount(1, $methods);

        static::assertSame('getFooProperty', $methods[0]->getName());
        static::assertSame($this->getGetterCode('getFooProperty', 'getterOnlyProperty'), $methods[0]->getCode());
    }

    private function getSetterCode(
        string $method = 'setProperty',
        string $property = 'property',
        string $parameter = 'property'
    ): string {
        return '    /** @param double $' . $parameter. ' */
    public function ' . $method . '(float $' . $parameter . '): self
    {
        $this->' . $property . ' = $' . $parameter . ';

        return $this;
    }';
    }

    private function getGetterCode(string $method = 'getProperty', string $property = 'property'): string
    {
        return '    /** @return double */
    public function ' . $method . '(): float
    {
        return $this->' . $property . ';
    }';
    }

    private function getNullableSetterCode(): string
    {
        return '    /** @param ?double $nullableProperty */
    public function setNullableProperty(?float $nullableProperty): self
    {
        $this->nullableProperty = $nullableProperty;

        return $this;
    }';
    }

    private function getNullableGetterCode(): string
    {
        return '    /** @return ?double */
    public function getNullableProperty(): ?float
    {
        return $this->nullableProperty;
    }';
    }
}
