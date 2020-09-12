<?php

namespace Desemax\ArtisanUI\Tests\Feature;

use Desemax\ArtisanUI\Http\Controllers\API\CommandsController;
use Desemax\ArtisanUI\Tests\TestCase;
use Illuminate\Http\Request;

class CommandsControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->json('GET', $this->baseUrl().'/commands');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'commands' => [],
            ])
            ->assertJsonFragment([
                'name' => 'env',
                'help' => '',
                'description' => 'Display the current framework environment',
                'arguments' => [],
                'options' => [],
            ]);
    }

    public function testItRetrievesTheArguments()
    {
        /**
         * @var Request
         */
        $request = app()->make(Request::class);
        $request->merge([
            'arguments' => [
                'name' => 'ArtisanUITestModel',
            ],
        ]);

        $controller = app()->make(CommandsController::class);
        $method = $this->getMethod(CommandsController::class, 'getArguments');

        $result = $method->invokeArgs($controller, [$request]);

        $this->assertIsArray($result);
        $this->assertEquals(['name' => 'ArtisanUITestModel'], $result);

        $request->merge([
            'options' => [
                'api',
                'force',
            ],
        ]);

        $result = $method->invokeArgs($controller, [$request]);

        $this->assertIsArray($result);
        $this->assertEquals([
            'name' => 'ArtisanUITestModel',
            '--api' => true,
            '--force' => true,
        ], $result);
    }

    public function testItRetrievesTheOptions()
    {
        /**
         * @var Request
         */
        $request = app()->make(Request::class);
        $request->merge([
            'options' => [
                'api',
                'force',
            ],
        ]);

        $controller = app()->make(CommandsController::class);
        $method = $this->getMethod(CommandsController::class, 'getOptions');

        $result = $method->invokeArgs($controller, [$request]);

        $this->assertIsArray($result);
        $this->assertContains([
            '--api',
            '--force',
        ], $result);
    }

    /**
     * @param string $class
     * @param string $method
     * @return \ReflectionMethod|string
     * @throws \ReflectionException
     */
    protected function getMethod(string $class, string $method)
    {
        $class = new \ReflectionClass($class);
        $method = $class->getMethod($method);
        $method->setAccessible(true);

        return $method;
    }

    public function testReturns422OnMissingName()
    {
        $response = $this->json('POST', $this->baseUrl().'/commands/run');

        $response
            ->assertStatus(422);
    }

    public function testItThrowsExceptionOnMissingArguments()
    {
        $response = $this->json('POST', $this->baseUrl().'/commands/run', [
            'name' => 'make:model',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonFragment([
                'status' => 1,
            ]);
    }

    public function testRun()
    {
        $response = $this->json('POST', $this->baseUrl().'/commands/run', [
            'name' => 'make:model',
            'arguments' => ['name' => 'ArtisanUITestModel'],
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'status' => 0,
            ]);
    }

    protected function baseUrl()
    {
        return config('artisanui.api.prefix').'/'.config('artisanui.api.version');
    }
}
