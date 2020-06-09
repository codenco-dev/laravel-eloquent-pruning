<?php


namespace CodencoDev\LaravelEloquentPruning\Console;


class StartPruning extends \Illuminate\Console\Command
{
    protected $signature = 'pruning:start {--hours : The number of hours to retain data}';

    protected $description = 'Start pruning for Eloquent models';

    public function handle()
    {
        $models = config('laravel-eloquent-pruning.models', []);
        $hours = $this->option('hours') ?: 0;
        foreach ($models as $model) {
            $pruned_count = (new $model)->prune(now()->subHours($hours));
            $this->info($pruned_count.' entries pruned.');
        }
    }
}