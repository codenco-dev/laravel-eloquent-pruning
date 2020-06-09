<?php


namespace CodencoDev\LaravelEloquentPruning\Tests;

use CodencoDev\LaravelEloquentPruning\LaravelEloquentPruningServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
        $this->withFactories(realpath(dirname(__DIR__).'/tests/TestModels/factories'));
        $this->setUpDatabase();
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelEloquentPruningServiceProvider::class,
        ];
    }

    protected function setUpDatabase()
    {
        $this->app['db']->connection()->getSchemaBuilder()->create('stuff_models', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });



    }
}
