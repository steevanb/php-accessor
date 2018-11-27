<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Annotation\Parser;

use steevanb\PhpAccessor\{
    CodeGenerator\CodeGeneratorInterface,
    CodeGenerator\SetterGetterCodeGenerator
};
use Symfony\Component\OptionsResolver\OptionsResolver;

class SetterGetterAnnotationParser implements AnnotationParserInterface
{
    public function supportsProperty(\ReflectionProperty $reflectionProperty, ?string $type): bool
    {
        return true;
    }

    public function configureOptions(OptionsResolver $resolver): AnnotationParserInterface
    {
        $this
            ->configureSetterOptions($resolver)
            ->configureGetterOptions($resolver);

        return $this;
    }

    public function getCodeGenerator(): CodeGeneratorInterface
    {
        return new SetterGetterCodeGenerator();
    }

    protected function configureSetterOptions(OptionsResolver $resolver): self
    {
        $resolver
            ->setDefault('setter', true)
            ->setAllowedTypes('setter', 'bool')

            ->setDefault('setterTemplate', null)
            ->setAllowedTypes('setterTemplate', ['null', 'string'])

            ->setDefault('setterMethod', null)
            ->setAllowedTypes('setterMethod', ['null', 'string'])

            ->setDefault('setterParameter', null)
            ->setAllowedTypes('setterParameter', ['null', 'string']);

        return $this;
    }

    protected function configureGetterOptions(OptionsResolver $resolver): self
    {
        $resolver
            ->setDefault('getter', true)
            ->setAllowedTypes('getter', 'bool')

            ->setDefault('getterMethod', null)
            ->setAllowedTypes('getterMethod', ['null', 'string'])

            ->setDefault('getterTemplate', null)
            ->setAllowedTypes('getterTemplate', ['null', 'string']);

        return $this;
    }
}
