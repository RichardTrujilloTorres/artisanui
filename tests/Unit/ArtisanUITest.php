<?php

namespace Desemax\ArtisanUI\Tests\Unit;

use Desemax\ArtisanUI\ArtisanUI;
use Desemax\ArtisanUI\Tests\TestCase;
use Illuminate\Foundation\Console\ModelMakeCommand;
use Symfony\Component\Console\Command\Command;

class ArtisanUITest extends TestCase
{
    /**
     * @var ArtisanUI
     */
    private $artisanUI;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisanUI = $this->instance(ArtisanUI::class, new ArtisanUI);
    }

    public function testItRetrievesTheArguments()
    {
        $this->assertObjectHasAttribute('name', $this->artisanUI->commands()[0]);

        $this->assertInstanceOf(Command::class, $this->artisanUI->commands()[0]);
    }

    public function testItRetrievesTheNames()
    {
        $this->assertContains('make:model', $this->artisanUI->names());
    }

    public function testItRetrievesTheNamespaces()
    {
        $this->assertContains('make', $this->artisanUI->namespaces());
    }

    public function testItRetrievesTheNamespace()
    {
        /**
         * @var ModelMakeCommand
         */
        $command = app()->make(ModelMakeCommand::class);

        $this->assertEquals('make', $this->artisanUI->getNamespace($command));
    }

    public function testItRetrievesTheIgnoredNamespaces()
    {
        $ignoredNamespaces = $this->artisanUI->ignoredNamespaces();
        $this->assertContains('vendor', $ignoredNamespaces);
        $this->assertIsArray($ignoredNamespaces);
    }
}
