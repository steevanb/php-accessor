<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\CodeGenerator;

use steevanb\PhpAccessor\{
    CodeGenerator\Behavior\GetGetterCodeTrait,
    CodeGenerator\Behavior\GetSetterCodeTrait,
    CodeGenerator\Behavior\TemplateTrait,
    Method\Method,
    Method\MethodArray,
    Property\PropertyDefinition
};

class SetterGetterCodeGenerator implements CodeGeneratorInterface
{
    use GetSetterCodeTrait;
    use GetGetterCodeTrait;
    use TemplateTrait;

    public function getMethods(
        PropertyDefinition $propertyDefinition,
        \ReflectionProperty $propertyReflection,
        array $config
    ): MethodArray
    {
        $methods = new MethodArray();

        $this
            ->addSetter($propertyDefinition, $propertyReflection, $config, $methods)
            ->addGetter($propertyDefinition, $propertyReflection, $config, $methods);

        return $methods;
    }

    /** @return $this */
    protected function addSetter(
        PropertyDefinition $propertyDefinition,
        \ReflectionProperty $propertyReflection,
        array $config,
        MethodArray $methods
    ): self {
        if ($config['setter'] === true) {
            $methodName = $config['setterMethod'] ?? 'set' . ucfirst($propertyReflection->getName());

            $setterConfig = [
                'type' => $config['type'],
                'template' => $config['setterTemplate'],
                'method' => $methodName,
                'parameter' => $config['setterParameter']
            ];
            $methods[] = (new Method($methodName))
                ->setCode($this->getSetterCode($propertyDefinition, $propertyReflection, $setterConfig));
        }

        return $this;
    }

    /** @return $this */
    protected function addGetter(
        PropertyDefinition $propertyDefinition,
        \ReflectionProperty $propertyReflection,
        array $config,
        MethodArray $methods
    ): self {
        if ($config['getter'] === true) {
            $methodName = $config['getterMethod'] ?? 'get' . ucfirst($propertyReflection->getName());

            $getterConfig = [
                'type' => $config['type'],
                'template' => $config['getterTemplate'],
                'method' => $methodName
            ];
            $methods[] = (new Method($methodName))
                ->setCode($this->getGetterCode($propertyDefinition, $propertyReflection, $getterConfig));
        }

        return $this;
    }
}
