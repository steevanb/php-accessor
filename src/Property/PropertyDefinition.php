<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Property;

use steevanb\PhpAccessor\Annotation\Accessors;
use steevanb\PhpAccessor\Method\MethodArray;

class PropertyDefinition
{
    /** @Accessors(var="string[]") */
    protected $methods;

    protected $classNamespace;

    protected $className;

    protected $name;

    public function __construct(?string $classNamespace, string $className, string $name)
    {
        $this->classNamespace = $classNamespace;
        $this->className = $className;
        $this->name = $name;
        $this->methods = new MethodArray();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addMethods(MethodArray $methods): self
    {
        foreach ($methods as $method) {
            $this->methods[] = $method;
        }

        return $this;
    }

    public function getMethods(): MethodArray
    {
        return $this->methods;
    }
}
