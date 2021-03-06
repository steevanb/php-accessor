<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\CodeWriter;

use steevanb\PhpAccessor\{CodeAnalyzer\CodeAnalyzerInterface,
    CodeGenerator\Behavior\TemplateTrait,
    Property\PropertyDefinitionArray,
    Report\Report};
use Symfony\Component\Filesystem\Filesystem;

class TraitCodeWriter implements CodeWriterInterface
{
    use TemplateTrait;

    /** @var string */
    protected $classFqcn;

    /** @var string */
    protected $traitDir;

    /** @var string */
    protected $traitNamespace;

    /** @var string */
    protected $traitName;

    /** @var PropertyDefinitionArray */
    protected $propertyDefinitions;

    /** @var ?\ReflectionClass */
    protected $traitReflection;

    /** @var Report */
    protected $report;

    public function __construct(CodeAnalyzerInterface $analyzer)
    {
        $this->classFqcn = $analyzer->getFqcn();
        $this->traitDir =
            dirname((new \ReflectionClass($this->classFqcn))->getFileName())
            . DIRECTORY_SEPARATOR
            . 'Accessors';
        $this->traitNamespace =
            (
                $analyzer->getClassNamespace() === null
                    ? null
                    : $analyzer->getClassNamespace() . '\\'
            )
            . 'Accessors';
        $this->traitName = $analyzer->getClassName() . 'AccessorsTrait';
        $this->traitReflection = trait_exists($this->traitNamespace . '\\' . $this->traitName)
            ? new \ReflectionClass($this->traitNamespace . '\\' . $this->traitName)
            : null;

        $this->propertyDefinitions = $analyzer->getPropertyDefinitions();
        $this->report = $analyzer->getReport();
    }

    public function getCode(): ?string
    {
        $accessorsCode = null;
        foreach ($this->propertyDefinitions as $propertyDefinition) {
            foreach ($propertyDefinition->getMethods() as $method) {
                $declarationAndCode = $method->getCode();
                if (
                    is_string($declarationAndCode)
                    && (
                        $this->traitReflection === null
                        || $this->traitReflection->hasMethod($method->getName()) === false
                    )
                ) {
                    $accessorsCode .=
                        (is_string($accessorsCode) && is_string($declarationAndCode) ? "\n\n" : null)
                        . $declarationAndCode;
                }

            }
        }

        return $this->getTraitCode($accessorsCode);
    }

    /** @return $this */
    public function write(): CodeWriterInterface
    {
        $code = $this->getCode();
        if (is_string($code)) {
            if (is_dir($this->traitDir) === false) {
                (new Filesystem())->mkdir($this->traitDir);
            }
            file_put_contents($this->traitDir . DIRECTORY_SEPARATOR . $this->traitName . '.php', $code);
        }

        return $this;
    }

    protected function getTraitCode(?string $accessorsCode): ?string
    {
        $return = null;
        if (is_string($accessorsCode)) {
            if ($this->traitReflection instanceof \ReflectionClass) {
                $return = null;
                $file = fopen($this->traitReflection->getFileName(), 'r');
                if (is_resource($file) === false) {
                    throw new \Exception('Trait file "' . $this->traitReflection->getFileName() . '"is not readable."');
                }

                for ($i = 0; $i < $this->traitReflection->getEndLine() - 1; $i++) {
                    $return .= fgets($file);
                }
                $return .= "\n" . '{{code}}' . "\n";
                while (($line = fgets($file)) !== false) {
                    $return .= $line;
                }
            } else {
                $return = $this->getTemplateContent(__DIR__ . '/Templates/trait.tpl');
            }

            $this->replaceTemplateVars(
                $return,
                [
                    'namespace' => $this->traitNamespace,
                    'traitName' => $this->traitName,
                    'className' => $this->classFqcn,
                    'code' => $accessorsCode
                ]
            );
        }

        return $return;
    }
}
