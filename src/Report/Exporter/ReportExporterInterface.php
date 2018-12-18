<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Report\Exporter;

use steevanb\PhpAccessor\Report\Report;

interface ReportExporterInterface
{
    public function setExportAllProperties(bool $export): ReportExporterInterface;

    public function setExportMethodCode(bool $export): ReportExporterInterface;

    public function export(Report $report): ReportExporterInterface;
}
