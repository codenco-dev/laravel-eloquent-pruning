<?php

namespace CodencoDev\LaravelEloquentPruning\Tests\TestModels;

use CodencoDev\LaravelEloquentPruning\Prunable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StuffConstrainedModel extends Model
{
    use Prunable;
    protected $fillable = ['id'];

    protected $table = 'stuff_models';

    public function canBePruned()
    {
        return $this->id != 1;
    }

    public function scopeCouldBePruned(Builder $query)
    {
        return $query->where('id','!=','1');
    }

}
