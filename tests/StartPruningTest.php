<?php

namespace CodencoDev\LaravelEloquentPruning\Tests;

use CodencoDev\LaravelEloquentPruning\Tests\TestModels\StuffConstrainedModel;
use CodencoDev\LaravelEloquentPruning\Tests\TestModels\StuffModel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class StartPruningTest extends TestCase
{
    /** @test */
    public function the_start_pruning_command_prune_one_model()
    {
        Config::set('laravel-eloquent-pruning.models', [StuffModel::class]);

        $this->assertCount(0, StuffModel::all());
        $hours = [3, 2, 0];
        foreach ($hours as $hour) {
            factory(StuffModel::class)->create([
                'created_at' => now()->subHour($hour),
            ]);
        }

        $this->assertCount(3, StuffModel::all());

        Artisan::call('pruning:start', ['--hours' => 1]);

        $this->assertCount(1, StuffModel::all());
    }

    public function the_start_pruning_command_has_hours_option()
    {
        Config::set('laravel-eloquent-pruning.models', [StuffModel::class]);

        $this->assertCount(0, StuffModel::all());
        $hours = [3, 2, 0];
        foreach ($hours as $hour) {
            factory(StuffModel::class)->create([
                'created_at' => now()->subHour($hour),
            ]);
        }

        $this->assertCount(3, StuffModel::all());

        Artisan::call('pruning:start', ['--hours' => 5]);

        $this->assertCount(3, StuffModel::all());

        Artisan::call('pruning:start', ['--hours' => 1]);

        $this->assertCount(1, StuffModel::all());
    }

    /** @test */
    public function the_start_pruning_command_prune_all_models()
    {
        Config::set('laravel-eloquent-pruning.models', [StuffModel::class, StuffConstrainedModel::class]);

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

        Artisan::call('pruning:start', ['--hours' => 1]);

        $this->assertCount(1, StuffModel::all());
        $this->assertCount(2, StuffConstrainedModel::all());
    }
}
