<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator\SetterGetterCodeGenerator;

use PHPUnit\Framework\TestCase;
use steevanb\PhpAccessor\{
    Tests\CodeGenerator\SetterGetterCodeGenerator\Behavior\AssertAccessorsTrait,
    Tests\CodeGenerator\SetterGetterCodeGenerator\Behavior\AssertNullableAccessorsTrait,
    Tests\StringAccessorsCases
};

final class StringTypeTest extends TestCase
{
    use GetMethodsTrait;
    use AssertAccessorsTrait;
    use AssertNullableAccessorsTrait;

    public function testAccessors(): void
    {
        static::assertAccessors(
            $this->getMethods(StringAccessorsCases::class, 'property', ['type' => 'string']),
            $this->getSetterCode(),
            $this->getGetterCode()
        );
    }

    public function testNullableAccessorsPhpTypeHint(): void
    {
        static::assertNullableAccessors(
            $this->getMethods(StringAccessorsCases::class, 'nullableProperty', ['type' => '?string']),
            $this->getNullableSetterCode(),
            $this->getNullableGetterCode()
        );
    }

    public function testNullableAccessorsPhpDocFirst(): void
    {
        static::assertNullableAccessors(
            $this->getMethods(StringAccessorsCases::class, 'nullableProperty', ['type' => 'null|string']),
            $this->getNullableSetterCode(),
            $this->getNullableGetterCode()
        );
    }

    public function testNullableAccessorsPhpDocLast(): void
    {
        static::assertNullableAccessors(
            $this->getMethods(StringAccessorsCases::class, 'nullableProperty', ['type' => 'string|null']),
            $this->getNullableSetterCode(),
            $this->getNullableGetterCode()
        );
    }

    public function testSetterOnly(): void
    {
        $methods = $this->getMethods(
            StringAccessorsCases::class,
            'setterOnlyProperty',
            [
                'type' => 'string',
                'getter' => false,
                'setterMethod' => 'setFooProperty'
            ]
        );
        static::assertCount(1, $methods);
        static::assertMethod('setFooProperty');

        static::assertSame('setFooProperty', $methods[0]->getName());
        static::assertSame(
            $this->getSetterCode('setFooProperty', 'setterOnlyProperty', 'setterOnlyProperty'),
            $methods[0]->getCode()
        );
    }

    public function testSetterParameterName(): void
    {
        $methods = $this->getMethods(
            StringAccessorsCases::class,
            'setterParamenterNameProperty',
            [
                'type' => 'string',
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
            StringAccessorsCases::class,
            'getterOnlyProperty',
            [
                'type' => 'string',
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
        return '    public function ' . $method . '(string $' . $parameter . '): self
    {
        $this->' . $property . ' = $' . $parameter . ';

        return $this;
    }';
    }

    private function getGetterCode(string $method = 'getProperty', string $property = 'property'): string
    {
        return '    public function ' . $method . '(): string
    {
        return $this->' . $property . ';
    }';
    }

    private function getNullableSetterCode(): string
    {
        return '    public function setNullableProperty(?string $nullableProperty): self
    {
        $this->nullableProperty = $nullableProperty;

        return $this;
    }';
    }

    private function getNullableGetterCode(): string
    {
        return '    public function getNullableProperty(): ?string
    {
        return $this->nullableProperty;
    }';
    }
}
