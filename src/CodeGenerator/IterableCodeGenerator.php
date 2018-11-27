<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\CodeGenerator;

use steevanb\PhpAccessor\{
    CodeGenerator\Behavior\RemovePluralTrait,
    Method\Method,
    Method\MethodArray,
    Property\PropertyDefinition,
    Property\PropertyType
};

class IterableCodeGenerator extends SetterGetterCodeGenerator
{
    use RemovePluralTrait;

    public function getMethods(
        PropertyDefinition $propertyDefinition,
        \ReflectionProperty $propertyReflection,
        array $config
    ): MethodArray {
        $methods = new MethodArray();

        $this
            ->addSetter($propertyDefinition, $propertyReflection, $config, $methods)
            ->addAdder($propertyDefinition, $propertyReflection, $config, $methods)
            ->addGetter($propertyDefinition, $propertyReflection, $config, $methods)
            ->addRemover($propertyDefinition, $propertyReflection, $config, $methods)
            ->addClearer($propertyDefinition, $config, $methods);

        return $methods;
    }

    protected function addAdder(
        PropertyDefinition $propertyDefinition,
        \ReflectionProperty $propertyReflection,
        array $config,
        MethodArray $methods
    ): self {
        if ($config['adder'] === true) {
            $phpDocType = PropertyType::getSingularPhpAndPhpDocTypes($config['type'], $propertyReflection)[1];
            $phpTypeHint = PropertyType::getSingularPhpTypeFromIterable($phpDocType, $config['adderAllowNull']);
            if (substr($config['type'], -2) === '[]' && strpos($config['type'], '|') === false) {
                $phpTypeHint = substr($config['type'], 0, -2);
                if (substr($phpTypeHint, 0, 1) !== '\\') {
                    $phpTypeHint = '\\' . $phpTypeHint;
                }
            }
            $methodName = $config['adderMethod'] ?? 'add' . $this->removePlural(ucfirst($propertyDefinition->getName()));

            $code = $this->getTemplateContent(
                $config['adderTemplate'] ?? __DIR__ . '/Templates/Iterable/adder.tpl'
            );

            $this->replaceTemplateVars(
                $code,
                [
                    'methodName' => $methodName,
                    'phpTypeHint' => $phpTypeHint,
                    'parameterName' => '$' . (
                        $config['adderParameter'] ?? $this->removePlural($propertyDefinition->getName())
                    ),
                    'property' => $propertyDefinition->getName()
                ]
            );

            $this->showTemplateBlock($code, 'phpTypeHint', is_string($phpTypeHint));

            $methods[] = (new Method($methodName))
                ->setCode($code);
        }

        return $this;
    }

    protected function addRemover(
        PropertyDefinition $propertyDefinition,
        \ReflectionProperty $propertyReflection,
        array $config,
        MethodArray $methods
    ): self {
        if ($config['remover'] === true) {
            $phpDocType = PropertyType::getSingularPhpAndPhpDocTypes($config['type'], $propertyReflection)[1];
            $methodName = $config['removerMethod'] ?? 'remove' . $this->removePlural(ucfirst($propertyDefinition->getName()));

            $code = $this->getTemplateContent(
                $config['removerTemplate'] ?? __DIR__ . '/Templates/Iterable/remover.tpl'
            );

            $this->replaceTemplateVars(
                $code,
                [
                    'methodName' => $methodName,
                    'parameterName' => '$' . ($config['removerParameter'] ?? 'index'),
                    'property' => $propertyDefinition->getName()
                ]
            );

            $this->showTemplateBlock($code, 'nullable', PropertyType::isNullable($phpDocType));

            $methods[] = (new Method($methodName))
                ->setCode($code);
        }

        return $this;
    }

    protected function addClearer(PropertyDefinition $propertyDefinition, array $config, MethodArray $methods ): self
    {
        if ($config['clearer'] === true) {
            $methodName = $config['clearerMethod'] ?? 'clear' . ucfirst($propertyDefinition->getName());

            $code = $this->getTemplateContent(
                $config['clearerTemplate'] ?? __DIR__ . '/Templates/Iterable/clearer.tpl'
            );

            $this->replaceTemplateVars(
                $code,
                [
                    'methodName' => $methodName,
                    'property' => $propertyDefinition->getName()
                ]
            );

            $methods[] = (new Method($methodName))
                ->setCode($code);
        }

        return $this;
    }
}