<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Command;

use steevanb\PhpAccessor\{
    CodeAnalyzer\FileCodeAnalyzer,
    CodeWriter\TraitCodeWriter,
    Report\Exporter\ConsoleReportExporter
};
use Symfony\Component\Console\{
    Command\Command,
    Input\InputArgument,
    Input\InputInterface,
    Output\OutputInterface
};
use steevanb\PhpTypedArray\ScalarArray\StringArray;

class GenerateCommand extends Command
{
    /** @var bool */
    protected $fileOrPathIsFile = false;

    /** @var ?string */
    protected $fileOrPathRealPath;

    /** @var bool */
    protected $isFirstFileNameOutputed = true;

    protected function configure(): void
    {
        parent::configure();

        $this
            ->setName('generate')
            ->addArgument('fileOrPath', InputArgument::REQUIRED, 'File name or path');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fileOrPath = $input->getArgument('fileOrPath');
        $exporter = (new ConsoleReportExporter($output))
            ->setExportAllProperties($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE)
            ->setExportMethodCode($output->getVerbosity() >= OutputInterface::VERBOSITY_DEBUG)
            ->setAddAnnotationColumn($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE);

        foreach ($this->getFiles($fileOrPath) as $file) {
            $analyzer = (new FileCodeAnalyzer($file))->analyze();
            $this->outputFileHeader($file, $output, $analyzer);

            if ($analyzer->getPropertyDefinitions()->count() > 0) {
                (new TraitCodeWriter($analyzer))->write();
            }

            $exporter->export($analyzer->getReport());
        }

        return 0;
    }

    protected function getFiles(string $fileOrPath): StringArray
    {
        $return = new StringArray();
        if (is_file($fileOrPath)) {
            $return[] = $fileOrPath;
            $this->fileOrPathIsFile = true;
        } elseif (is_dir($fileOrPath)) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(
                    $fileOrPath,
                    \FilesystemIterator::FOLLOW_SYMLINKS
                )
            );
            /** @var \SplFileInfo $file */
            foreach ($files as $file) {
                if ($file->getType() === 'file') {
                    $return[] = $file->getRealPath();
                }
            }

            $this->fileOrPathRealPath = realpath($fileOrPath);
        } else {
            throw new \Exception('"' . $fileOrPath . '" is not a file or a directory.');
        }

        return $return;
    }

    protected function outputFileHeader(
        string $fileName,
        OutputInterface $output,
        FileCodeAnalyzer $analyzer
    ): self {
        if (
            $this->fileOrPathIsFile === false
            && (
                $analyzer->getPropertyDefinitions()->count() > 0
                || $output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE
            )
        ) {
            if ($this->isFirstFileNameOutputed === false) {
                $output->writeln('');
            }

            $output->writeln('<comment>' . $analyzer->getFqcn() . '</comment>');
            $output->writeln('File: ' . $fileName);

            $this->isFirstFileNameOutputed = false;
        }

        return $this;
    }
}
