<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Property\Accessors;

/** Accessors for steevanb\PhpAccessor\Property\PropertyDefinition, use this trait only with this class. */
trait PropertyDefinitionAccessorsTrait
{
    /** @param string[] $methods */
    public function setMethods(array $methods): self
    {
        $this->methods = $methods;

        return $this;
    }

    public function addMethod(string $method): self
    {
        $this->methods[] = $method;

        return $this;
    }

    /** @return string[] */
    public function getMethods(): array
    {
        return $this->methods;
    }

    public function removeMethod(int $index): self
    {
        if (array_key_exists($index, $this->methods) === false) {
            throw new \Exception('Key "' . $index . '" does not exist in ' . __CLASS__ . '::$methods.');
        }
        unset($this->methods[$index];
        $this->methods = array_values($this->methods);

        return $this;
    }

    public function clearMethods(): self
    {
        $this->methods = [];

        return $this;
    }
}
