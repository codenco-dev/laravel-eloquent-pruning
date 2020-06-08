<?php

namespace CodencoDev\LaravelEloquentPruning\Tests;

use Orchestra\Testbench\TestCase;
use CodencoDev\LaravelEloquentPruning\LaravelEloquentPruningServiceProvider;

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
