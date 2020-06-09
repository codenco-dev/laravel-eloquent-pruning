<?php

namespace CodencoDev\LaravelEloquentPruning\Tests\TestModels;

use CodencoDev\LaravelEloquentPruning\Prunable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StuffConstrainedWithEventModel extends Model
{
    use Prunable;
    protected $fillable = ['id'];


    public function canBePruned()
    {
        return $this->id != 1;
    }

    public function scopeCouldBePruned(Builder $query)
    {
        return $query;
    }

}
