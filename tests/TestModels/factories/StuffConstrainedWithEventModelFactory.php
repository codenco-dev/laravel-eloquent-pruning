<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use CodencoDev\LaravelEloquentPruning\Tests\TestModels\StuffConstrainedWithEventModel;
use Faker\Generator as Faker;

$factory->define(StuffConstrainedWithEventModel::class, function (Faker $faker) {
    return [
        'created_at' => now(),
    ];
});
