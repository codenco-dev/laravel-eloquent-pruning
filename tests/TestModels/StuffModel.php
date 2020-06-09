<?php

namespace CodencoDev\LaravelEloquentPruning\Tests\TestModels;

use CodencoDev\LaravelEloquentPruning\Prunable;
use Illuminate\Database\Eloquent\Model;

class StuffModel extends Model
{
    use Prunable;
    protected $fillable = ['id'];

}
