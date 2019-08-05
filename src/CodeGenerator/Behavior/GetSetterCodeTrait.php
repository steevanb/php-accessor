<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\CodeGenerator\Behavior;

use steevanb\PhpAccessor\{
    Property\PropertyDefinition,
    Property\PropertyType
};

trait GetSetterCodeTrait
{
    abstract protected function getTemplateContent(string $filePath): string;

    abstract protected function replaceTemplateVars(string &$code, array $vars): void;

    abstract protected function showTemplateBlock(string &$code, string $name, bool $show = true): void;

    protected function getSetterCode(
        PropertyDefinition $propertyDefinition,
        \ReflectionProperty $propertyReflection,
        array $config
    ): ?string {
        [$phpTypeHint, $phpDocType] = PropertyType::getPhpAndPhpDocTypes($config['type'], $propertyReflection);

        $return = $this->getTemplateContent(
            $config['template'] ?? __DIR__ . '/../Templates/SetterGetter/setter.tpl'
        );

        $this->replaceTemplateVars(
            $return,
            [
                'phpDocParameterType' => $phpDocType,
                'methodName' => $config['method'] ?? 'set' . ucfirst($propertyDefinition->getName()),
                'phpTypeHint' => $phpTypeHint,
                'parameterName' => '$' . ($config['parameter'] ?? $propertyDefinition->getName()),
                'property' => $propertyDefinition->getName()
            ]
        );

        $this->showTemplateBlock($return, 'phpTypeHint', is_string($phpTypeHint));
        $this->showTemplateBlock($return, 'phpDoc', $phpTypeHint !== $phpDocType);

        return $return;
    }
}
