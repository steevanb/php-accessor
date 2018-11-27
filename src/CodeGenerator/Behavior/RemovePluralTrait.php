<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\CodeGenerator\Behavior;

trait RemovePluralTrait
{
    protected function removePlural(string $string): string
    {
        return (strlen($string) > 1 && substr($string, -1) === 's') ? substr($string, 0, -1) : $string;
    }
}
