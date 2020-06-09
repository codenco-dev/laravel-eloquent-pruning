<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use CodencoDev\LaravelEloquentPruning\Tests\TestModels\StuffModel;
use Faker\Generator as Faker;

$factory->define(StuffModel::class, function (Faker $faker) {
    return [
        'created_at' => now()
    ];
});
