<?php

namespace CodencoDev\LaravelEloquentPruning\Tests\TestModels;

use CodencoDev\LaravelEloquentPruning\Prunable;
use Illuminate\Database\Eloquent\Model;

class StuffWithOverwriteModel extends Model
{
    use Prunable;

    protected $fillable = ['id'];

    public function getHours(): int
    {
        return 1;
    }

    public function getPruningColumn(): string
    {
        return 'test_column';
    }

    public function getChunkSize(): int
    {
        return 1000;
    }

    public function getWithDeleteEvents(): bool
    {
        return false;
    }
}
