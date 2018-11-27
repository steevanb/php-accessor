<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Annotation\Parser;

use steevanb\PhpAccessor\CodeGenerator\CodeGeneratorInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface AnnotationParserInterface
{
    public function supportsProperty(\ReflectionProperty $reflectionProperty, string $type): bool;

    public function configureOptions(OptionsResolver $resolver): self;

    public function getCodeGenerator(): CodeGeneratorInterface;
}
