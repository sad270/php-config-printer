<?php

declare(strict_types=1);

namespace Symplify\PhpConfigPrinter\Tests\Printer\PhpParserPhpConfigPrinter\Source;

final class TaggedServiceCollection
{
    public function __construct(
        public array $taggedServices = [],
    ) {
    }
}
