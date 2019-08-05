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
    Property\PropertyType,
    Report\PropertyReport,
    Report\Report
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

    /** @var string */
    protected $fqcn;

    /** @var \ReflectionClass */
    protected $reflectionClass;

    /** @var PropertyDefinitionArray */
    protected $propertyDefinitions;

    /** @var Report */
    protected $report;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
        [$this->namespace, $this->className] = static::getNamespaceAndClassName();
        $this->fqcn = ($this->namespace === null) ? $this->className : $this->namespace . '\\' . $this->className;
        $this->reflectionClass = new \ReflectionClass($this->fqcn);
        $this->propertyDefinitions = new PropertyDefinitionArray();
        $this->report = (new Report($this->reflectionClass->getName()))
            ->setFileName($fileName);

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

    public function getFqcn(): string
    {
        return $this->fqcn;
    }

    public function getReport(): Report
    {
        return $this->report;
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
    public function analyzeProperty(string $name): CodeAnalyzerInterface
    {
        $propertyReflection = $this->reflectionClass->getProperty($name);
        $propertyDefinition = new PropertyDefinition($this->getClassNamespace(), $this->getClassName(), $name);
        $this->report->addProperty(new PropertyReport($propertyDefinition));

        /** @var Accessors $annotation */
        $annotation = (new AnnotationReader())->getPropertyAnnotation($propertyReflection, Accessors::class);
        if ($annotation instanceof Accessors) {
            $propertyType = PropertyType::parsePropertyType($annotation->getVar());
            $parser = is_string($annotation->getParser())
                ? AnnotationParserService::getSingleton()->getParser($annotation->getParser())
                : AnnotationParserService::getSingleton()->getParserFromProperty($propertyReflection, $propertyType);

            $optionsResolver = (new OptionsResolver());
            $parser->configureOptions($optionsResolver);
            $options = $optionsResolver->resolve($annotation->getOptions());
            $options['type'] = $propertyType;

            $propertyDefinition
                ->setHasAnnotation(true)
                ->addMethods(
                    $parser->getCodeGenerator()->getMethods($propertyDefinition, $propertyReflection, $options)
                );

            $this->addPropertyDefinition($propertyDefinition);
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
        $class = null;
        $namespace = null;
        $tokens = token_get_all(file_get_contents($this->fileName));

        for ($i = 0; $i < count($tokens); $i++) {
            if (is_array($tokens[$i])) {
                if ($tokens[$i][0] === T_NAMESPACE) {
                    for ($j = $i + 1; $j < count($tokens); $j++) {
                        if (is_array($tokens[$j]) && $tokens[$j][0] === T_STRING) {
                            $namespace .= (is_string($namespace) ? '\\' : null) . $tokens[$j][1];
                        } elseif (is_string($tokens[$j]) && ($tokens[$j] === '{' || $tokens[$j] === ';')) {
                            break;
                        }
                    }
                } elseif ($tokens[$i][0] === T_CLASS || $tokens[$i][0] === T_TRAIT) {
                    for ($j = $i + 1; $j < count($tokens); $j++) {
                        if ($tokens[$j] === '{') {
                            $class = $tokens[$i + 2][1];
                            break 2;
                        }
                    }
                }
            }
        }

        return [$namespace, $class];
    }
}
