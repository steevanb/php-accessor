<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\CodeAnalyzer;

use steevanb\PhpAccessor\{
    Property\PropertyDefinition,
    Property\PropertyDefinitionArray
};

interface CodeAnalyzerInterface
{
    public function getClassNamespace(): ?string;

    public function getClassName(): string;

    public function analyze(): self;

    public function analyzeProperty(string $property): self;

    public function addPropertyDefinition(PropertyDefinition $definition): self;

    public function getPropertyDefinitions(): PropertyDefinitionArray;
}
