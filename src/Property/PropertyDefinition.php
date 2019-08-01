<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Property;

use steevanb\PhpAccessor\Annotation\Accessors;
use steevanb\PhpAccessor\Method\MethodDefinitionArray;
use steevanb\PhpAccessor\Property\Accessors\PropertyDefinitionAccessorsTrait;

class PropertyDefinition
{
    use PropertyDefinitionAccessorsTrait;

    /** @var MethodDefinitionArray */
    protected $methods;

    /** @var ?string */
    protected $classNamespace;

    /** @var string */
    protected $className;

    /** @Accessors(var="string", setter=false) */
    protected $name;

    /** @Accessors(var="string", getterMethod="hasAnnotation") */
    protected $hasAnnotation = false;

    public function __construct(?string $classNamespace, string $className, string $name)
    {
        $this->classNamespace = $classNamespace;
        $this->className = $className;
        $this->name = $name;
        $this->methods = new MethodDefinitionArray();
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
}
