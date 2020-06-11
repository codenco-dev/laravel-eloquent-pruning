<?php

namespace CodencoDev\LaravelEloquentPruning\Console;

use CodencoDev\LaravelEloquentPruning\LaravelEloquentPruningFacade;

class StartPruning extends \Illuminate\Console\Command
{
    protected $signature = 'pruning:start {--hours : The number of hours to retain data}';

    protected $description = 'Start pruning for Eloquent models';

    public function handle()
    {
        $pruned_count = LaravelEloquentPruningFacade::prune($this->option('hours') ?: 0);
        $this->info($pruned_count.' entries pruned.');
    }
}
