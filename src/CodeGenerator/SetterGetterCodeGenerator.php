<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\CodeGenerator;

use steevanb\PhpAccessor\{
    CodeGenerator\Behavior\GetGetterCodeTrait,
    CodeGenerator\Behavior\GetSetterCodeTrait,
    CodeGenerator\Behavior\TemplateTrait,
    Method\MethodDefinition,
    Method\MethodDefinitionArray,
    Property\PropertyDefinition
};

class SetterGetterCodeGenerator implements CodeGeneratorInterface
{
    use GetSetterCodeTrait;
    use GetGetterCodeTrait;
    use TemplateTrait;

    public function getMethods(PropertyDefinition $propertyDefinition, array $config): MethodDefinitionArray
    {
        $methods = new MethodDefinitionArray();

        $this
            ->addSetter($propertyDefinition, $config, $methods)
            ->addGetter($propertyDefinition, $config, $methods);

        return $methods;
    }

    /** @return $this */
    protected function addSetter(
        PropertyDefinition $propertyDefinition,
        array $config,
        MethodDefinitionArray $methods
    ): self {
        if ($config['setter'] === true) {
            $methodName = $config['setterMethod'] ?? 'set' . ucfirst($propertyDefinition->getName());

            $setterConfig = [
                'type' => $config['type'],
                'template' => $config['setterTemplate'],
                'method' => $methodName,
                'parameter' => $config['setterParameter']
            ];
            $methods[] = (new MethodDefinition($methodName))
                ->setCode($this->getSetterCode($propertyDefinition, $setterConfig));
        }

        return $this;
    }

    /** @return $this */
    protected function addGetter(
        PropertyDefinition $propertyDefinition,
        array $config,
        MethodDefinitionArray $methods
    ): self {
        if ($config['getter'] === true) {
            $methodName = $config['getterMethod'] ?? 'get' . ucfirst($propertyDefinition->getName());

            $getterConfig = [
                'type' => $config['type'],
                'template' => $config['getterTemplate'],
                'method' => $methodName
            ];
            $methods[] = (new MethodDefinition($methodName))
                ->setCode($this->getGetterCode($propertyDefinition, $getterConfig));
        }

        return $this;
    }
}
