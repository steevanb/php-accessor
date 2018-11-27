<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\CodeAnalyzer;

use Doctrine\Common\Annotations\{
    AnnotationReader,
    AnnotationRegistry
};
use steevanb\PhpAccessor\{
    Annotation\Accessors,
    Annotation\Parser\AnnotationParserService,
    Property\PropertyDefinition,
    Property\PropertyDefinitionArray,
    Property\PropertyType
};
use Symfony\Component\OptionsResolver\OptionsResolver;

class FileCodeAnalyzer implements CodeAnalyzerInterface
{
    /** @var string */
    protected $fileName;

    /** @var string */
    protected $namespace;

    /** @var string */
    protected $className;

    /** @var \ReflectionClass */
    protected $reflectionClass;

    /** @var PropertyDefinitionArray */
    protected $propertyDefinitions;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
        [$this->namespace, $this->className] = static::getNamespaceAndClassName();
        $this->reflectionClass = new \ReflectionClass(
            ($this->namespace === null) ? $this->className : $this->namespace . '\\' . $this->className
        );
        $this->propertyDefinitions = new PropertyDefinitionArray();

        AnnotationRegistry::registerFile(__DIR__ . '/../Annotation/Accessors.php');
    }

    public function getClassNamespace(): ?string
    {
        return $this->reflectionClass->getNamespaceName();
    }

    public function getClassName(): string
    {
        return $this->reflectionClass->getShortName();
    }

    /** @return $this */
    public function analyze(): CodeAnalyzerInterface
    {
        foreach ($this->reflectionClass->getProperties() as $property) {
            $this->analyzeProperty($property->getName());
        }

        return $this;
    }

    /** @return $this */
    public function analyzeProperty(string $property): CodeAnalyzerInterface
    {
        $propertyReflection = $this->reflectionClass->getProperty($property);
        /** @var Accessors $annotation */
        $annotation = (new AnnotationReader())->getPropertyAnnotation($propertyReflection, Accessors::class);

        if ($annotation instanceof Accessors) {
            $propertyDefinition = new PropertyDefinition($this->getClassNamespace(), $this->getClassName(), $property);
            $propertyType = PropertyType::parsePropertyType($annotation->getVar());
            $parser = is_string($annotation->getParser())
                ? AnnotationParserService::getSingleton()->getParser($annotation->getParser())
                : AnnotationParserService::getSingleton()->getParserFromProperty($propertyReflection, $propertyType);

            $optionsResolver = (new OptionsResolver());
            $parser->configureOptions($optionsResolver);
            $options = $optionsResolver->resolve($annotation->getOptions());
            $options['type'] = $propertyType;

            $propertyDefinition->addMethods(
                $parser->getCodeGenerator()->getMethods($propertyDefinition, $propertyReflection, $options)
            );

            $this->propertyDefinitions[] = $propertyDefinition;
        }

        return $this;
    }

    /** @return $this */
    public function addPropertyDefinition(PropertyDefinition $definition): CodeAnalyzerInterface
    {
        $this->propertyDefinitions[] = $definition;

        return $this;
    }

    public function getPropertyDefinitions(): PropertyDefinitionArray
    {
        return $this->propertyDefinitions;
    }

    protected function getNamespaceAndClassName(): array
    {
        $class = $namespace = null;
        $tokens = token_get_all(file_get_contents($this->fileName));

        for ($i = 0; $i < count($tokens); $i++) {
            if (is_array($tokens[$i])) {
                if ($tokens[$i][0] === T_NAMESPACE) {
                    for ($j = $i + 1; $j < count($tokens); $j++) {
                        if (is_array($tokens[$j]) && $tokens[$j][0] === T_STRING) {
                            $namespace .= (is_string($namespace) ? '\\' : null) . $tokens[$j][1];
                        } else if (is_string($tokens[$j]) && ($tokens[$j] === '{' || $tokens[$j] === ';')) {
                            break;
                        }
                    }
                } elseif ($tokens[$i][0] === T_CLASS) {
                    for ($j = $i + 1; $j < count($tokens); $j++) {
                        if ($tokens[$j] === '{') {
                            $class = $tokens[$i + 2][1];
                        }
                    }
                }
            }
        }

        return [$namespace, $class];
    }
}
