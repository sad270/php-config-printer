<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\PhpConfigPrinter\Tests\Printer\PhpParserPhpConfigPrinter\Source\TaggedServiceCollection;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(TaggedServiceCollection::class)
        ->args([
        tagged_iterator(tag: 'app.handler', defaultIndexMethod: 'getIndex'),
    ]);
};
