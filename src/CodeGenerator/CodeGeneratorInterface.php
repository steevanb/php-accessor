<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\CodeGenerator;

use steevanb\PhpAccessor\{
    Method\MethodArray,
    Property\PropertyDefinition
};

interface CodeGeneratorInterface
{
    public function getMethods(
        PropertyDefinition $propertyDefinition,
        \ReflectionProperty $propertyReflection,
        array $config
    ): MethodArray;
}
