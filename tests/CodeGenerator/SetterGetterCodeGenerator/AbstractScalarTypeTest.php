<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator\SetterGetterCodeGenerator;

use PHPUnit\Framework\TestCase;
use steevanb\PhpAccessor\{
    CodeGenerator\SetterGetterCodeGenerator,
    Method\MethodDefinitionArray,
    Property\PropertyDefinition,
    Tests\CodeGenerator\SetterGetterCodeGenerator\Behavior\AssertMethodTrait
};

abstract class AbstractScalarTypeTest extends TestCase
{
    use AssertMethodTrait;

    abstract protected function getPhpTypeHint(): string;

    abstract protected function getClassToTest(): string;

    public function testAccessors(): void
    {
        $methods = $this->getMethods($this->getClassToTest(), 'property', $this->getTypeConfig());

        static::assertCount(2, $methods);

        static::assertMethod('setProperty', $this->getSetterCode(), $methods[0]);
        static::assertMethod('getProperty', $this->getGetterCode(), $methods[1]);
    }

    public function testNullableAccessorsPhpTypeHint(): void
    {
        static::assertNullableAccessors('nullablePropertyPhpTypeHint', '?' . $this->getAnnotationType());
    }

    public function testNullableAccessorsPhpDocFirst(): void
    {
        static::assertNullableAccessors('nullablePropertyPhpTypeHint', 'null|' . $this->getAnnotationType());
    }

    public function testNullableAccessorsPhpDocLast(): void
    {
        static::assertNullableAccessors('nullablePropertyPhpTypeHint', $this->getAnnotationType() . '|null');
    }

    public function testSetterOnly(): void
    {
        $methods = $this->getMethods(
            $this->getClassToTest(),
            'propertySetterOnly',
            [
                'type' => $this->getAnnotationType(),
                'getter' => false
            ]
        );
        static::assertCount(1, $methods);
        static::assertMethod(
            'setPropertySetterOnly',
            $this->getSetterCode('setPropertySetterOnly', 'propertySetterOnly', 'propertySetterOnly'),
            $methods[0]
        );
    }

    public function testRenamedSetter(): void
    {
        $methods = $this->getMethods(
            $this->getClassToTest(),
            'propertyRenamedSetter',
            [
                'type' => $this->getAnnotationType(),
                'setterMethod' => 'renamedSetter'
            ]
        );
        static::assertCount(2, $methods);
        static::assertMethod(
            'renamedSetter',
            $this->getSetterCode('renamedSetter', 'propertyRenamedSetter', 'propertyRenamedSetter'),
            $methods[0]
        );
    }

    public function testRenamedSetterParameter(): void
    {
        $methods = $this->getMethods(
            $this->getClassToTest(),
            'propertySetterRenamedParameter',
            [
                'type' => $this->getAnnotationType(),
                'setterParameter' => 'renamedParameter'
            ]
        );
        static::assertCount(2, $methods);
        static::assertMethod(
            'setPropertySetterRenamedParameter',
            $this->getSetterCode(
                'setPropertySetterRenamedParameter',
                'propertySetterRenamedParameter',
                'renamedParameter'
            ),
            $methods[0]
        );
    }

    public function testGetterOnly(): void
    {
        $methods = $this->getMethods(
            $this->getClassToTest(),
            'propertyGetterOnly',
            [
                'type' => $this->getAnnotationType(),
                'setter' => false
            ]
        );
        static::assertCount(1, $methods);
        static::assertMethod(
            'getPropertyGetterOnly',
            $this->getGetterCode('getPropertyGetterOnly', 'propertyGetterOnly'),
            $methods[0]
        );
    }

    public function testRenamedGetter(): void
    {
        $methods = $this->getMethods(
            $this->getClassToTest(),
            'propertyRenamedGetter',
            [
                'type' => $this->getAnnotationType(),
                'getterMethod' => 'renamedGetter'
            ]
        );
        static::assertCount(2, $methods);
        static::assertMethod(
            'renamedGetter',
            $this->getGetterCode('renamedGetter', 'propertyRenamedGetter'),
            $methods[1]
        );
    }

    protected function getSetterCode(
        string $method = 'setProperty',
        string $property = 'property',
        string $parameter = 'property'
    ): string {
        return '    public function ' . $method . '(' . $this->getPhpTypeHint() . ' $' . $parameter . '): self
    {
        $this->' . $property . ' = $' . $parameter . ';

        return $this;
    }';
    }

    protected function getGetterCode(string $method = 'getProperty', string $property = 'property'): string
    {
        return '    public function ' . $method . '(): ' . $this->getPhpTypeHint() . '
    {
        return $this->' . $property . ';
    }';
    }

    protected function getNullableSetterCode(string $property): string
    {
        // phpcs:ignore
        return '    public function set' . ucfirst($property) . '(?' . $this->getPhpTypeHint() . ' $' . $property . '): self
    {
        $this->' . $property . ' = $' . $property . ';

        return $this;
    }';
    }

    protected function getNullableGetterCode(string $property): string
    {
        return '    public function get' . ucfirst($property) . '(): ?' . $this->getPhpTypeHint() . '
    {
        return $this->' . $property . ';
    }';
    }

    protected function assertNullableAccessors(string $property, string $type): self
    {
        $methods = $this->getMethods($this->getClassToTest(), $property, ['type' => $type]);
        static::assertCount(2, $methods);

        static::assertSame('set' . ucfirst($property), $methods[0]->getName());
        static::assertSame($this->getNullableSetterCode($property), $methods[0]->getCode());

        static::assertSame('get' . ucfirst($property), $methods[1]->getName());
        static::assertSame($this->getNullableGetterCode($property), $methods[1]->getCode());

        return $this;
    }

    protected function getTypeConfig(): array
    {
        return ['type' => $this->getAnnotationType()];
    }

    protected function getMethods(string $fqcn, string $property, array $config): MethodDefinitionArray
    {
        return (new SetterGetterCodeGenerator())
            ->getMethods(
                new PropertyDefinition($fqcn, basename($fqcn), $property),
                array_merge(
                    [
                        'setter' => true,
                        'setterTemplate' => null,
                        'setterMethod' => null,
                        'setterParameter' => null,
                        'getter' => true,
                        'getterMethod' => null,
                        'getterTemplate' => null,
                        'type' => null
                    ],
                    $config
                )
            );
    }

    protected function getAnnotationType(): string
    {
        return $this->getPhpTypeHint();
    }
}
