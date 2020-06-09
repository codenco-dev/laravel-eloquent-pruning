<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use CodencoDev\LaravelEloquentPruning\Tests\TestModels\StuffConstrainedModel;
use Faker\Generator as Faker;

$factory->define(StuffConstrainedModel::class, function (Faker $faker) {
    return [
        'created_at' => now()
    ];
});
