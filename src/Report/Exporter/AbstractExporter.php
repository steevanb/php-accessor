<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Report\Exporter;

abstract class AbstractExporter implements ReportExporterInterface
{
    /** @var bool */
    protected $exportAllProperties = false;

    /** @var bool */
    protected $exportMethodCode = false;

    /** @return $this */
    public function setExportAllProperties(bool $export): ReportExporterInterface
    {
        $this->exportAllProperties = $export;

        return $this;
    }

    /** @return $this */
    public function setExportMethodCode(bool $export): ReportExporterInterface
    {
        $this->exportMethodCode = $export;

        return $this;
    }
}
