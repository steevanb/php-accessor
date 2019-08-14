<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Tests\CodeAnalyzer;

class DoubleAccessorsCasesTest extends AbstractSetterGetterFileCodeAnalyzerTest
{
    protected function getFilePath(): string
    {
        return __DIR__ . '/../AccessorsCases/DoubleAccessorsCases.php';
    }
}
