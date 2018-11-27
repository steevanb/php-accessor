<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Annotation\Parser;

use steevanb\PhpAccessor\{
    CodeGenerator\CodeGeneratorInterface,
    CodeGenerator\IterableCodeGenerator
};
use Symfony\Component\OptionsResolver\OptionsResolver;

class DoctrineManyToOneAnnotationParser implements AnnotationParserInterface
{
    public function supportsProperty(\ReflectionProperty $reflectionProperty, ?string $type): bool
    {
        throw new \Exception('TODO');
        return $return;
    }

    public function configureOptions(OptionsResolver $resolver): AnnotationParserInterface
    {
        throw new \Exception('TODO');
        return $this;
    }

    public function getCodeGenerator(): CodeGeneratorInterface
    {
        throw new \Exception('TODO');
        return new IterableCodeGenerator();
    }
}
