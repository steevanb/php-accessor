<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Report\Exporter;

use steevanb\PhpAccessor\{
    Report\MethodReport,
    Report\Report
};
use Symfony\Component\Console\{
    Helper\Table,
    Helper\TableSeparator,
    Output\OutputInterface
};

class ConsoleReportExporter extends AbstractExporter
{
    /** @var OutputInterface */
    protected $output;

    /** @var bool */
    protected $addAnnotationColumn = false;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function setAddAnnotationColumn(bool $addAnnotationColumn): self
    {
        $this->addAnnotationColumn = $addAnnotationColumn;

        return $this;
    }

    public function export(Report $report): ReportExporterInterface
    {
        if ($report->getProperties()->count() > 0) {
            $table = new Table($this->output);
            $table->setHeaders(
                $this->addAnnotationColumn
                    ? ['Property', 'Annotation', 'Methods', 'Written']
                    : ['Property', 'Methods', 'Written']
            );
            $writeSeparator = false;
            foreach ($report->getProperties() as $property) {
                if ($property->getPropertyDefinition()->hasAnnotation() || $this->exportAllProperties) {
                    if ($writeSeparator) {
                        $table->addRow(new TableSeparator());
                    }

                    $annotation = $property->getPropertyDefinition()->hasAnnotation() ? '@Accessors()' : 'None';
                    $methods = [];
                    $writtenStates = [];
                    foreach ($property->getPropertyDefinition()->getMethods() as $method) {
                        $methods[] = $method->getName() . '()';
                        $writtenStates[] = $this->methodWrittenToString(
                            $property->getMethod($method->getName())->getWritten()
                        );
                    }

                    $row = ['$' . $property->getPropertyDefinition()->getName()];
                    if ($this->addAnnotationColumn) {
                        $row[] = $annotation;
                    }
                    $row[] = implode("\n", $methods);
                    $row[] = implode("\n", $writtenStates);
                    $table->addRow($row);

                    $writeSeparator = true;
                }
            }
            $table->render();
        } elseif ($this->exportAllProperties) {
            $this->output->writeln('No properties with @Accessors annotation found.');
        }

        return $this;
    }

    protected function methodWrittenToString(int $written): string
    {
        $return = null;
        switch ($written) {
            case MethodReport::WRITTEN_NO:
                $return = 'No';
                break;
            case MethodReport::WRITTEN_NO_ALREADY_EXIST:
                $return = 'No (already exist)';
                break;
            case MethodReport::WRITTEN_YES:
                $return = 'Yes';
                break;
            default:
                $return = (string) $written;
                break;
        }

        return $return;
    }
}
