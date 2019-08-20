<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator\IterableCodeGenerator;

use PHPUnit\Framework\TestCase;
use steevanb\PhpAccessor\{
    CodeGenerator\IterableCodeGenerator,
    Method\MethodDefinitionArray,
    Property\PropertyDefinition,
    Tests\CodeGenerator\SetterGetterCodeGenerator\Behavior\AssertMethodTrait
};

abstract class AbstractIteratorTest extends TestCase
{
    use AssertMethodTrait;

    abstract protected function getPhpTypeHint(): string;

    abstract protected function getClassToTest(): string;

    public function testAccessors(): void
    {
        $methods = $this->getMethods($this->getClassToTest(), 'property', $this->getTypeConfig());

        static::assertCount(5, $methods);

        static::assertMethod('setProperty', $this->getSetterCode(), $methods[0]);
        static::assertMethod('addProperty', $this->getAdderCode(), $methods[1]);
        static::assertMethod('getProperty', $this->getGetterCode(), $methods[2]);
        static::assertMethod('removeProperty', $this->getRemoverCode(), $methods[3]);
        static::assertMethod('clearProperty', $this->getClearerCode(), $methods[4]);
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

    protected function getAdderCode(): string
    {
        return '    public function addProperty($property): self
    {
        $this->property[] = $property;

        return $this;
    }';
    }

    protected function getRemoverCode(): string
    {
        return '    public function removeProperty(int $index): self
    {
        if (array_key_exists($index, $this->property) === false) {
            throw new \Exception(\'Key "\' . $index . \'" does not exist in \' . __CLASS__ . \'::$property.\');
        }
        unset($this->property[$index]);
        $this->property = array_values($this->property);

        return $this;
    }';
    }

    protected function getClearerCode(): string
    {
        return '    public function clearProperty(): self
    {
        $this->property = [];

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

    protected function getTypeConfig(): array
    {
        return ['type' => $this->getAnnotationType()];
    }

    protected function getMethods(string $fqcn, string $property, array $config): MethodDefinitionArray
    {
        return (new IterableCodeGenerator())
            ->getMethods(
                new PropertyDefinition($fqcn, basename($fqcn), $property),
                array_merge(
                    [
                        'setter' => true,
                        'setterTemplate' => null,
                        'setterMethod' => null,
                        'setterParameter' => null,
                        'adder' => true,
                        'adderTemplate' => null,
                        'adderMethod' => null,
                        'adderParameter' => null,
                        'adderAllowNull' => true,
                        'remover' => true,
                        'removerTemplate' => null,
                        'removerMethod' => null,
                        'removerParameter' => null,
                        'getter' => true,
                        'getterMethod' => null,
                        'getterTemplate' => null,
                        'clearer' => true,
                        'clearerMethod' => null,
                        'clearerTemplate' => null,
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
