<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeAnalyzer;

use PHPUnit\Framework\TestCase;
use steevanb\PhpAccessor\CodeAnalyzer\FileCodeAnalyzer;

final class FileCodeAnalyzerTest extends TestCase
{
    public function testGetClassNamespace(): void
    {
        $analyzer = $this->getFileCodeAnalyzer();
        static::assertSame('steevanb\PhpAccessor\Tests', $analyzer->getClassNamespace());
    }

    public function testGetClassName(): void
    {
        $analyzer = $this->getFileCodeAnalyzer();
        static::assertSame('AllAccessorsCases', $analyzer->getClassName());
    }

    public function testGetFqcn(): void
    {
        $analyzer = $this->getFileCodeAnalyzer();
        static::assertSame('steevanb\PhpAccessor\Tests\AllAccessorsCases', $analyzer->getFqcn());
    }

    public function testAnalyze(): void
    {
        $analyzer = $this->getFileCodeAnalyzer();
        $analyze = $analyzer->analyze();

        $properties = [
            'unknownType',
            'string',
            'nullableString',
            'stringGetter',
            'stringSetter',
            'stringSetterParameterName',
            'int',
            'nullableInt',
            'intGetter',
            'intSetter',
            'intSetterParameterName',
            'integer',
            'float',
            'double',
            'array',
            'iterable',
            'dateTime',
            'allAccessorsCases'
        ];
        static::assertCount(count($properties), $analyze->getPropertyDefinitions());
        foreach ($analyze->getPropertyDefinitions() as $propertyIndex => $propertyDefinition) {
            static::assertSame($properties[$propertyIndex], $propertyDefinition->getName());
        }
    }

    private function getFileCodeAnalyzer(): FileCodeAnalyzer
    {
        return new FileCodeAnalyzer(__DIR__ . '/../AllAccessorsCases.php');
    }
}
