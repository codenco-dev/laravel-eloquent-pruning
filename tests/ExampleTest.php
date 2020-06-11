<?php

namespace CodencoDev\LaravelEloquentPruning\Tests;

use CodencoDev\LaravelEloquentPruning\LaravelEloquentPruningServiceProvider;
use Orchestra\Testbench\TestCase;

class ExampleTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [LaravelEloquentPruningServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
