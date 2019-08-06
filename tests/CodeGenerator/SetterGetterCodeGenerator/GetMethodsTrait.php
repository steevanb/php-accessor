<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeGenerator\SetterGetterCodeGenerator;

use steevanb\PhpAccessor\{
    CodeGenerator\SetterGetterCodeGenerator,
    Method\MethodDefinitionArray,
    Property\PropertyDefinition,
    Tests\AllAccessorsCases
};

trait GetMethodsTrait
{
    protected function getMethods(string $property, array $config): MethodDefinitionArray
    {
        return (new SetterGetterCodeGenerator())
            ->getMethods(
                new PropertyDefinition(AllAccessorsCases::class, basename(AllAccessorsCases::class), $property),
                new \ReflectionProperty(AllAccessorsCases::class, $property),
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
