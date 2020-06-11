<?php

namespace CodencoDev\LaravelEloquentPruning\Tests;

use CodencoDev\LaravelEloquentPruning\Tests\TestModels\StuffConstrainedModel;
use CodencoDev\LaravelEloquentPruning\Tests\TestModels\StuffConstrainedWithEventModel;
use CodencoDev\LaravelEloquentPruning\Tests\TestModels\StuffModel;
use CodencoDev\LaravelEloquentPruning\Tests\TestModels\StuffWithOverwriteModel;
use CodencoDev\LaravelEloquentPruning\Tests\TestModels\StuffWithPropertiesModel;
use Illuminate\Support\Facades\Config;

class PrunableTest extends TestCase
{
    /** @test */
    public function prunable_model_has_pruning_column_attribute()
    {
        $m = new StuffModel();
        $m->setPruningColumn('test_column');
        $this->assertEquals($m->getPruningColumn(), 'test_column');
    }

    /** @test */
    public function prunable_model_has_hours_column_attribute()
    {
        $m = new StuffModel();
        $m->setHours(1);
        $this->assertEquals($m->getHours(), 1);
    }

    /** @test */
    public function prunable_model_has_chunk_size_column_attribute()
    {
        $m = new StuffModel();
        $m->setChunkSize(1);
        $this->assertEquals($m->getChunkSize(), 1);
    }

    /** @test */
    public function prunable_model_has_with_delete_event_column_attribute()
    {
        $m = new StuffModel();
        $m->setWithDeleteEvents(true);
        $this->assertEquals($m->getWithDeleteEvents(), true);
        $m->setWithDeleteEvents(false);
        $this->assertEquals($m->getWithDeleteEvents(), false);
    }

    /** @test */
    public function prunable_model_has_attributes_with_config_value_if_null()
    {
        $m = new StuffModel();
        $this->assertEquals($m->getPruningColumn(), Config::get('laravel-eloquent-pruning.pruning_column'));
        $this->assertEquals($m->getHours(), Config::get('laravel-eloquent-pruning.hours'));
        $this->assertEquals($m->getChunkSize(), Config::get('laravel-eloquent-pruning.chunk_size'));
        $this->assertEquals($m->getWithDeleteEvents(), Config::get('laravel-eloquent-pruning.with_delete_events'));
    }

    /** @test */
    public function prunable_model_can_declare_properties()
    {
        $m = new StuffWithPropertiesModel();
        $this->assertEquals($m->getPruningColumn(), 'test_column');
        $this->assertEquals($m->getHours(), 1);
        $this->assertEquals($m->getChunkSize(), 1000);
        $this->assertEquals($m->getWithDeleteEvents(), false);
    }

    /** @test */
    public function prunable_model_can_overwrite_method()
    {
        $m = new StuffWithOverwriteModel();
        $this->assertEquals($m->getPruningColumn(), 'test_column');
        $this->assertEquals($m->getHours(), 1);
        $this->assertEquals($m->getChunkSize(), 1000);
        $this->assertEquals($m->getWithDeleteEvents(), false);
    }

    /** @test */
    public function model_prunable_can_be_prune()
    {
        $this->assertCount(0, StuffModel::all());
        $hours = [3, 2, 0];
        foreach ($hours as $hour) {
            factory(StuffModel::class)->create([
                'created_at' => now()->subHour($hour),
            ]);
        }

        $this->assertCount(3, StuffModel::all());

        $m = StuffModel::make();
        $m->setHours(1);
        $m->prune();

        $this->assertCount(1, StuffModel::all());
    }

    /** @test */
    public function model_prunable_can_be_prune_with_with_delete_event_to_true()
    {
        $this->assertCount(0, StuffModel::all());
        $hours = [3, 2, 0];
        foreach ($hours as $hour) {
            factory(StuffModel::class)->create([
                'created_at' => now()->subHour($hour),
            ]);
        }

        $this->assertCount(3, StuffModel::all());

        $m = StuffModel::make();

        $m->setWithDeleteEvents(true);
        $m->setHours(1);
        $m->prune();

        $this->assertCount(1, StuffModel::all());
    }

    /** @test */
    public function model_prunable_can_be_prune_with_with_delete_event_to_false()
    {
        $this->assertCount(0, StuffModel::all());
        $hours = [3, 2, 0];
        foreach ($hours as $hour) {
            factory(StuffModel::class)->create([
                'created_at' => now()->subHour($hour),
            ]);
        }

        $this->assertCount(3, StuffModel::all());

        $m = StuffModel::make();
        $m->setWithDeleteEvents(false);
        $m->setHours(1);
        $m->prune();

        $this->assertCount(1, StuffModel::all());
    }

    /** @test */
    public function model_prunable_can_have_prune_condition()
    {
        $this->assertCount(0, StuffConstrainedModel::all());
        $hours = [3, 2, 0];
        foreach ($hours as $hour) {
            factory(StuffConstrainedModel::class)->create([
                'created_at' => now()->subHour($hour),
            ]);
        }

        $this->assertCount(3, StuffConstrainedModel::all());

        $m = StuffConstrainedModel::make();
        $m->setHours(1);
        $m->prune();

        $this->assertCount(2, StuffConstrainedModel::all());
    }

    /** @test */
    public function prune_configuration_allows_use_false_for_with_event()
    {
        Config::set('laravel-eloquent-pruning.with_delete_events', false);
        $this->assertCount(0, StuffConstrainedWithEventModel::all());
        $hours = [3, 2, 0];
        foreach ($hours as $hour) {
            factory(StuffConstrainedWithEventModel::class)->create([
                'created_at' => now()->subHour($hour),
            ]);
        }

        $this->assertCount(3, StuffConstrainedWithEventModel::all());

        $m = StuffConstrainedWithEventModel::make();
        $m->setHours(1);
        $m->prune();

        $this->assertCount(1, StuffConstrainedWithEventModel::all());
    }

    /** @test */
    public function prune_configuration_allows_use_true_for_with_event()
    {
        Config::set('laravel-eloquent-pruning.with_delete_events', true);
        $this->assertCount(0, StuffConstrainedWithEventModel::all());
        $hours = [3, 2, 0];
        foreach ($hours as $hour) {
            factory(StuffConstrainedWithEventModel::class)->create([
                'created_at' => now()->subHour($hour),
            ]);
        }

        $this->assertCount(3, StuffConstrainedWithEventModel::all());

        $m = StuffConstrainedWithEventModel::make();
        $m->setHours(1);
        $m->prune();

        $this->assertCount(2, StuffConstrainedWithEventModel::all());
    }
}
