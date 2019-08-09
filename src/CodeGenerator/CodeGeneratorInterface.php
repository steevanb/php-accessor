<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\CodeGenerator;

use steevanb\PhpAccessor\{
    Method\MethodDefinitionArray,
    Property\PropertyDefinition
};

interface CodeGeneratorInterface
{
    public function getMethods(PropertyDefinition $propertyDefinition, array $config): MethodDefinitionArray;
}
