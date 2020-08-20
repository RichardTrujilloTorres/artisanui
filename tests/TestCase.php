<?php

namespace Desemax\ArtisanUI\Tests;

use Desemax\ArtisanUI\ArtisanUIServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ArtisanUIServiceProvider::class,
        ];
    }
}
