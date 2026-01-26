<?php

declare(strict_types=1);

namespace Symplify\PhpConfigPrinter\Tests\Printer\PhpParserPhpConfigPrinter;

use Symfony\Component\Yaml\Tag\TaggedValue;
use Symplify\PhpConfigPrinter\NodeFactory\ContainerConfiguratorReturnClosureFactory;
use Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter;
use Symplify\PhpConfigPrinter\Tests\AbstractTestCase;
use Symplify\PhpConfigPrinter\Tests\Printer\PhpParserPhpConfigPrinter\Source\TaggedServiceCollection;
use Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\FirstClass;
use Symplify\PhpConfigPrinter\Yaml\CheckerServiceParametersShifter;

final class PhpParserPhpConfigPrinterTest extends AbstractTestCase
{
    private PhpParserPhpConfigPrinter $phpParserPhpConfigPrinter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->phpParserPhpConfigPrinter = $this->getService(PhpParserPhpConfigPrinter::class);
        $this->containerConfiguratorReturnClosureFactory = $this->getService(ContainerConfiguratorReturnClosureFactory::class);
        $this->checkerServiceParametersShifter = $this->getService(CheckerServiceParametersShifter::class);
    }

    public function testTaggedService(): void
    {
        $yamlArray = [
            'services' => [
                TaggedServiceCollection::class => [
                    'arguments' => [
                        new TaggedValue(
                            tag: 'tagged_iterator',
                            value: [
                                'tag' => 'app.handler',
                                'default_index_method' => 'getIndex',
                            ],
                        ),
                    ],
                ],
            ],
        ];

        $yamlArray = $this->checkerServiceParametersShifter->process($yamlArray);
        $stmt = $this->containerConfiguratorReturnClosureFactory->createFromYamlArray($yamlArray);

        $printedContent = $this->phpParserPhpConfigPrinter->prettyPrintFile([$stmt]);
        $this->assertStringEqualsFile(__DIR__ . '/Fixture/expected_tagged_service_collection.php.inc', $printedContent);
    }
}
