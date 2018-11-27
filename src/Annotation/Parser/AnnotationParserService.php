<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Annotation\Parser;

class AnnotationParserService
{
    /** @var ?AnnotationParserFactory */
    protected static $singleton;

    public static function getSingleton(): self
    {
        if (static::$singleton instanceof static === false) {
            static::$singleton = new static();
        }

        return static::$singleton;
    }

    /** @var array */
    protected $parsers = [];

    public function __construct()
    {
        $this
            ->registerParser('iterable', new IterableAnnotationParser(), -10)
            ->registerParser('setterGetter', new SetterGetterAnnotationParser(), -100);
    }

    public function registerParser(string $name, AnnotationParserInterface $parser, int $priority = 0): self
    {
        if (isset($this->parsers[$priority]) === false) {
            $this->parsers[$priority] = [];
            krsort($this->parsers);
        }
        $this->parsers[$priority][$name] = $parser;

        return $this;
    }

    public function getParser(string $name): AnnotationParserInterface
    {
        $return = null;
        foreach ($this->parsers as $parsers) {
            if (isset($parsers[$name])) {
                $return = $parsers[$name];
                break;
            }
        }
        if ($return === null) {
            throw new \Exception('Unknown annotation parser "' . $name . '".');
        }

        return $return;
    }

    public function getParserFromProperty(
        \ReflectionProperty $reflectionProperty,
        ?string $propertyType
    ): AnnotationParserInterface {
        $return = null;
        foreach ($this->parsers as $parsers) {
            /** @var AnnotationParserInterface $parser */
            foreach ($parsers as $parser) {
                if ($parser->supportsProperty($reflectionProperty, $propertyType)) {
                    $return = $parser;
                    break 2;
                }
            }
        }

        if ($return instanceof AnnotationParserInterface === false) {
            throw new \Exception('AnnotationParser for "' . $propertyType . '" not found');
        }

        return $return;
    }
}
