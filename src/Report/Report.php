<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Report;

class Report
{
    /** @var string */
    protected $className;

    /** @var ?string */
    protected $fileName;

    /** @var PropertyReportArray */
    protected $properties;

    public function __construct(string $className)
    {
        $this->className = $className;
        $this->properties = new PropertyReportArray();
    }

    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function getProperties(): PropertyReportArray
    {
        return $this->properties;
    }

    public function addProperty(PropertyReport $property): self
    {
        $this->properties[] = $property;

        return $this;
    }
}
