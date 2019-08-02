<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator;

use Doctrine\Common\Annotations\AnnotationReader;
use PHPUnit\Framework\TestCase;
use steevanb\PhpAccessor\Annotation\Accessors;
use steevanb\PhpAccessor\CodeAnalyzer\FileCodeAnalyzer;
use steevanb\PhpAccessor\CodeGenerator\SetterGetterCodeGenerator;
use steevanb\PhpAccessor\Method\MethodDefinitionArray;
use steevanb\PhpAccessor\Property\PropertyDefinition;
use steevanb\PhpAccessor\Property\PropertyType;
use steevanb\PhpAccessor\Tests\AllAccessorsCases;

final class SetterGetterCodeGeneratorTest extends TestCase
{
    public function testUnknownTypePropertyMethods(): void
    {
        $methods = $this->getMethods('unknownType');
        static::assertCount(2, $methods);

        static::assertSame('setUnknownType', $methods[0]->getName());
        static::assertSame('getUnknownType', $methods[1]->getName());
    }

    private function getMethods(string $property): MethodDefinitionArray
    {
        $analyzer = new FileCodeAnalyzer(__DIR__ . '/../AllAccessorsCases.php');
        $generator = new SetterGetterCodeGenerator();
        $propertyReflection = new \ReflectionProperty(AllAccessorsCases::class, $property);
        $annotation = (new AnnotationReader())->getPropertyAnnotation($propertyReflection, Accessors::class);
        $propertyType = PropertyType::parsePropertyType($annotation->getVar());
        $options = $analyzer->configureAnnotationOptions(
            $analyzer->getAnnotationParser($annotation, $propertyReflection, $propertyType),
            $annotation,
            $propertyType
        );

        return $generator->getMethods(
            new PropertyDefinition(AllAccessorsCases::class, basename(AllAccessorsCases::class), $property),
            $propertyReflection,
            $options
        );
    }
}
