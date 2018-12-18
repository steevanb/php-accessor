<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Property;

use steevanb\PhpAccessor\{
    Annotation\Accessors,
    Method\MethodDefinitionArray
};

class PropertyDefinition
{
    /** @Accessors(var="string[]") */
    protected $methods;

    /** @var ?string */
    protected $classNamespace;

    /** @var string */
    protected $className;

    /** @var string */
    protected $name;

    /** @var bool */
    protected $hasAnnotation = false;

    public function __construct(?string $classNamespace, string $className, string $name)
    {
        $this->classNamespace = $classNamespace;
        $this->className = $className;
        $this->name = $name;
        $this->methods = new MethodDefinitionArray();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addMethods(MethodDefinitionArray $methods): self
    {
        foreach ($methods as $method) {
            $this->methods[] = $method;
        }

        return $this;
    }

    public function getMethods(): MethodDefinitionArray
    {
        return $this->methods;
    }

    public function setHasAnnotation(bool $hasAnnotation): self
    {
        $this->hasAnnotation = $hasAnnotation;

        return $this;
    }

    public function hasAnnotation(): bool
    {
        return $this->hasAnnotation;
    }
}
