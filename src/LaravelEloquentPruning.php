<?php

namespace CodencoDev\LaravelEloquentPruning;

class LaravelEloquentPruning
{
    private $models = null;

    public function prune(int $hours = 0)
    {
        $pruned_count = 0;
        foreach ($this->getModels() as $model) {
            $pruned_count += (new $model)->prune(now()->subHours($hours));
        }

        return $pruned_count;
    }

    /**
     * @return array
     */
    public function getModels(): array
    {
        return $this->models ?? config('laravel-eloquent-pruning.models', []);
    }

    /**
     * @param  array  $models
     * @return LaravelEloquentPruning
     */
    public function setModels(?array $models): self
    {
        $this->models = $models;

        return $this;
    }
}
