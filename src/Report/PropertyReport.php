<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Report;

use steevanb\PhpAccessor\Property\PropertyDefinition;

class PropertyReport
{
    /** @var PropertyDefinition */
    protected $propertyDefinition;

    /** @var MethodReportArray */
    protected $methods;

    public function __construct(PropertyDefinition $propertyDefinition)
    {
        $this->propertyDefinition = $propertyDefinition;
        $this->methods = new MethodReportArray();
    }

    public function getPropertyDefinition(): PropertyDefinition
    {
        return $this->propertyDefinition;
    }

    public function getMethods(): MethodReportArray
    {
        return $this->methods;
    }

    public function hasMethod(string $name): bool
    {
        return $this->getMethodOrNull($name) instanceof MethodReport;
    }

    public function getMethod(string $name): MethodReport
    {
        $return = $this->getMethodOrNull($name);
        if ($return === null) {
            throw new \Exception(
                'Method report "' . $name . '" not found for property ' . $this->getPropertyDefinition()->getName() . '.'
            );
        }

        return $return;
    }

    protected function getMethodOrNull(string $name): ?MethodReport
    {
        $return = $this->methods[$name] ?? null;
        if ($return === null) {
            foreach ($this->getPropertyDefinition()->getMethods() as $method) {
                if ($method->getName() === $name) {
                    $return = $this->methods[$name] = new MethodReport($name, $method);
                    break;
                }
            }
        }

        return $return;
    }
}
