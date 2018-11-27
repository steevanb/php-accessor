<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\CodeWriter;

interface CodeWriterInterface
{
    public function getCode(): ?string;

    public function write(): self;
}
