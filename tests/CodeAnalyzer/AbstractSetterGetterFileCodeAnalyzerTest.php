<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeAnalyzer;

use PHPUnit\Framework\TestCase;
use steevanb\PhpAccessor\CodeAnalyzer\FileCodeAnalyzer;

abstract class AbstractSetterGetterFileCodeAnalyzerTest extends TestCase
{
    abstract protected function getFilePath(): string;

    public function testGetClassNamespace(): void
    {
        static::assertSame(
            $this->getNamespace(),
            $this->getFileCodeAnalyzer()->getClassNamespace()
        );
    }

    public function testGetClassName(): void
    {
        static::assertSame($this->getClassName(), $this->getFileCodeAnalyzer()->getClassName());
    }

    public function testGetFqcn(): void
    {
        static::assertSame(
            $this->getNamespace() . '\\' . $this->getClassName(),
            $this->getFileCodeAnalyzer()->getFqcn()
        );
    }

    public function testAnalyze(): void
    {
        $analyzer = $this->getFileCodeAnalyzer();
        $analyze = $analyzer->analyze();

        $properties = [
            'property',
            'nullablePropertyPhpTypeHint',
            'nullablePropertyPhpDocFirst',
            'nullablePropertyPhpDocLast',
            'propertySetterOnly',
            'propertyRenamedSetter',
            'propertySetterRenamedParameter',
            'propertyGetterOnly',
            'propertyRenamedGetter'
        ];
        static::assertCount(count($properties), $analyze->getPropertyDefinitions());

        foreach ($analyze->getPropertyDefinitions() as $propertyIndex => $propertyDefinition) {
            static::assertSame($properties[$propertyIndex], $propertyDefinition->getName());
            static::assertSame(true, $propertyDefinition->hasAnnotation());
        }
    }

    private function getFileCodeAnalyzer(): FileCodeAnalyzer
    {
        return new FileCodeAnalyzer($this->getFilePath());
    }

    private function getClassName(): string
    {
        return substr(basename($this->getFilePath()), 0, -4);
    }

    private function getNamespace(): string
    {
        return 'steevanb\PhpAccessor\Tests\AccessorsCases';
    }
}
