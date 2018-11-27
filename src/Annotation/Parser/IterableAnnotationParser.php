<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Annotation\Parser;

use phpDocumentor\Reflection\{
    TypeResolver,
    Types\Array_,
    Types\Iterable_,
    Types\Nullable
};
use steevanb\PhpAccessor\{
    CodeGenerator\CodeGeneratorInterface,
    CodeGenerator\IterableCodeGenerator
};
use Symfony\Component\OptionsResolver\OptionsResolver;

class IterableAnnotationParser extends SetterGetterAnnotationParser
{
    public function supportsProperty(\ReflectionProperty $reflectionProperty, ?string $type): bool
    {
        if (is_string($type) && strpos($type, '|') === false) {
            $types = (new TypeResolver())->resolve($type);
            $realType = ($types instanceof Nullable) ? $types->getActualType() : $types;
            $return = ($realType instanceof Array_ || $realType instanceof Iterable_);
        } else {
            $return = false;
        }

        return $return;
    }

    public function configureOptions(OptionsResolver $resolver): AnnotationParserInterface
    {
        parent::configureOptions($resolver);

        $this
            ->configureAdderOptions($resolver)
            ->configureRemoverOptions($resolver)
            ->configureClearerOptions($resolver);

        return $this;
    }

    public function getCodeGenerator(): CodeGeneratorInterface
    {
        return new IterableCodeGenerator();
    }

    protected function configureAdderOptions(OptionsResolver $resolver): self
    {
        $resolver
            ->setDefault('adder', true)
            ->setAllowedTypes('adder', 'bool')

            ->setDefault('adderTemplate', null)
            ->setAllowedTypes('adderTemplate', ['null', 'string'])

            ->setDefault('adderMethod', null)
            ->setAllowedTypes('adderMethod', ['null', 'string'])

            ->setDefault('adderAllowNull', false)
            ->setAllowedTypes('adderAllowNull', ['bool'])

            ->setDefault('adderParameter', null)
            ->setAllowedTypes('adderParameter', ['null', 'string']);

        return $this;
    }

    protected function configureRemoverOptions(OptionsResolver $resolver): self
    {
        $resolver
            ->setDefault('remover', true)
            ->setAllowedTypes('remover', 'bool')

            ->setDefault('removerTemplate', null)
            ->setAllowedTypes('removerTemplate', ['null', 'string'])

            ->setDefault('removerMethod', null)
            ->setAllowedTypes('removerMethod', ['null', 'string'])

            ->setDefault('removerParameter', null)
            ->setAllowedTypes('removerParameter', ['null', 'string']);

        return $this;
    }

    protected function configureClearerOptions(OptionsResolver $resolver): self
    {
        $resolver
            ->setDefault('clearer', true)
            ->setAllowedTypes('clearer', 'bool')

            ->setDefault('clearerTemplate', null)
            ->setAllowedTypes('clearerTemplate', ['null', 'string'])

            ->setDefault('clearerMethod', null)
            ->setAllowedTypes('clearerMethod', ['null', 'string']);

        return $this;
    }
}
