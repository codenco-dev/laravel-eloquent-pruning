<?php

namespace CodencoDev\LaravelEloquentPruning;

use Illuminate\Support\Facades\Facade;

/**
 * @see \CodencoDev\LaravelEloquentPruning\Skeleton\SkeletonClass
 */
class LaravelEloquentPruningFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-eloquent-pruning';
    }
}
