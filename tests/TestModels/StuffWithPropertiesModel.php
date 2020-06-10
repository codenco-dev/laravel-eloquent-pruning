<?php

namespace CodencoDev\LaravelEloquentPruning\Tests\TestModels;

use CodencoDev\LaravelEloquentPruning\Prunable;
use Illuminate\Database\Eloquent\Model;

class StuffWithPropertiesModel extends Model
{
    use Prunable;

    protected $fillable = ['id'];

    protected $hours = 1;
    protected $pruningColumn = 'test_column';
    protected $chunkSize = 1000;
    protected $withDeleteEvents = false;

}
