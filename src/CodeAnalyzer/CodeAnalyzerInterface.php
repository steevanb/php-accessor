<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\CodeAnalyzer;

use steevanb\PhpAccessor\{
    Property\PropertyDefinition,
    Property\PropertyDefinitionArray,
    Report\Report
};

interface CodeAnalyzerInterface
{
    public function getClassNamespace(): ?string;

    public function getClassName(): string;

    public function getFqcn(): string;

    public function getReport(): Report;

    public function analyze(): self;

    public function analyzeProperty(string $name): self;

    public function addPropertyDefinition(PropertyDefinition $definition): self;

    public function getPropertyDefinitions(): PropertyDefinitionArray;
}
