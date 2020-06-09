<?php

namespace CodencoDev\LaravelEloquentPruning\Tests;

use CodencoDev\LaravelEloquentPruning\LaravelEloquentPruningFacade;
use CodencoDev\LaravelEloquentPruning\Tests\TestModels\StuffConstrainedModel;
use CodencoDev\LaravelEloquentPruning\Tests\TestModels\StuffModel;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class LaravelEloquentPruningTest extends TestCase
{
    use WithFaker;

    /** @test */

    function has_models_attribute()
    {
        $model = $this->faker->name;
        $o = LaravelEloquentPruningFacade::setModels([$model]);
        $this->assertEquals($o->getModels(), [$model]);
    }

    public function prune_one_model()
    {
        $pruning = LaravelEloquentPruningFacade::setModels([StuffModel::class]);

        $this->assertCount(0, StuffModel::all());
        $hours = [3, 2, 0];
        foreach ($hours as $hour) {
            factory(StuffModel::class)->create([
                'created_at' => now()->subHour($hour),
            ]);
        }

        $this->assertCount(3, StuffModel::all());

        $pruning->prune(1);

        $this->assertCount(1, StuffModel::all());

    }

    public function has_hours_option()
    {
        $pruning = LaravelEloquentPruningFacade::setModels([StuffModel::class]);

        $this->assertCount(0, StuffModel::all());
        $hours = [3, 2, 0];
        foreach ($hours as $hour) {
            factory(StuffModel::class)->create([
                'created_at' => now()->subHour($hour),
            ]);
        }

        $this->assertCount(3, StuffModel::all());

        LaravelEloquentPruningFacade::prune(5);

        $this->assertCount(3, StuffModel::all());

        $pruning->prune(1);

        $this->assertCount(1, StuffModel::all());

    }

    /** @test */

    public function prune_all_models()
    {
        $pruning = LaravelEloquentPruningFacade::setModels([StuffModel::class, StuffConstrainedModel::class]);

        $this->assertCount(0, StuffModel::all());
        $this->assertCount(0, StuffConstrainedModel::all());

        $hours = [3, 2, 0];
        foreach ($hours as $hour) {
            factory(StuffModel::class)->create([
                'created_at' => now()->subHour($hour),
            ]);
            factory(StuffConstrainedModel::class)->create([
                'created_at' => now()->subHour($hour),
            ]);
        }


        $this->assertCount(3, StuffModel::all());
        $this->assertCount(3, StuffConstrainedModel::all());

        $pruning->prune(1);

        $this->assertCount(1, StuffModel::all());
        $this->assertCount(2, StuffConstrainedModel::all());


    }
}
