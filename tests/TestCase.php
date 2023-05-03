<?php

namespace Kanagama\LaravelCollectionDeduplicate\Tests;

use Kanagama\LaravelCollectionDeduplicate\CollectionMethodServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * @param  $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            CollectionMethodServiceProvider::class,
        ];
    }
}
