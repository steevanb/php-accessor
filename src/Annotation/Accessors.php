<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Annotation;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Accessors
{
    /**
     * Hack to have auto-completion in PHPStorm for @Accessors(var="", type=""):
     * create $var property, and stock all annotation values inside, instead of just "var" configuration.
     * To be consistent with "var" PHPDoc keyword, we use "var" config name to specify property "type"
     * @var string
     */
    protected $var;

    /** @var string */
    protected $parser;

    public function __construct(array $values)
    {
        $this->parser = $values['parser'] ?? null;
        unset($values['parser']);
        $this->var = $values;
        $this->var['var'] = $values['var'] ?? null;
    }

    /** Return specific options (all options minus var and parser) */
    public function getOptions(): array
    {
        // can't save result in protected / private property, as AnnotationRegistry use class properties for himself
        $return = $this->var;
        unset($return['var']);

        return $return;
    }

    public function getVar(): ?string
    {
        return $this->var['var'];
    }

    public function getParser(): ?string
    {
        return $this->parser;
    }
}
