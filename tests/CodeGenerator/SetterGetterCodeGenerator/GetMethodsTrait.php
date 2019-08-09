<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator\SetterGetterCodeGenerator;

use steevanb\PhpAccessor\{
    CodeGenerator\SetterGetterCodeGenerator,
    Method\MethodDefinitionArray,
    Property\PropertyDefinition
};

trait GetMethodsTrait
{
    protected function getMethods(string $fqcn, string $property, array $config): MethodDefinitionArray
    {
        return (new SetterGetterCodeGenerator())
            ->getMethods(
                new PropertyDefinition($fqcn, basename($fqcn), $property),
                array_merge(
                    [
                        'setter' => true,
                        'setterTemplate' => null,
                        'setterMethod' => null,
                        'setterParameter' => null,
                        'getter' => true,
                        'getterMethod' => null,
                        'getterTemplate' => null,
                        'type' => null
                    ],
                    $config
                )
            );
    }
}
