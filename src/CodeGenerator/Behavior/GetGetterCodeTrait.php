<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\CodeGenerator\Behavior;

use steevanb\PhpAccessor\{
    Property\PropertyDefinition,
    Property\PropertyType
};

trait GetGetterCodeTrait
{
    // use TemplateTrait to include them
    abstract protected function getTemplateContent(string $filePath): string;
    abstract protected function replaceTemplateVars(string &$code, array $vars): void;
    abstract protected function showTemplateBlock(string &$code, string $name, bool $show = true): void;

    protected function getGetterCode(
        PropertyDefinition $propertyDefinition,
        \ReflectionProperty $propertyReflection,
        array $config
    ): ?string {
        [$phpTypeHint, $phpDocType] = PropertyType::getPhpAndPhpDocTypes($config['type'], $propertyReflection);

        $return = $this->getTemplateContent(
            $config['template'] ?? __DIR__ . '/../Templates/SetterGetter/getter.tpl'
        );

        $this->replaceTemplateVars(
            $return,
            [
                'phpDocReturnType' => $phpDocType,
                'methodName' => $config['method'] ?? 'get' . ucfirst($propertyDefinition->getName()),
                'returnType' => $phpTypeHint,
                'property' => $propertyDefinition->getName()
            ]
        );

        $this->showTemplateBlock($return, 'return', is_string($phpTypeHint));
        $this->showTemplateBlock($return, 'phpDoc', $phpTypeHint !== $phpDocType);

        return $return;
    }
}