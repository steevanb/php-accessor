<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Property\Accessors;

/** Accessors for steevanb\PhpAccessor\Property\PropertyDefinition, use this trait only with this class. */
trait PropertyDefinitionAccessorsTrait
{
    public function getName(): string
    {
        return $this->name;
    }

    public function setHasAnnotation(string $hasAnnotation): self
    {
        $this->hasAnnotation = $hasAnnotation;

        return $this;
    }

    public function hasAnnotation(): string
    {
        return $this->hasAnnotation;
    }
}
