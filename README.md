# Easily prune your Eloquent Model Records

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codenco-dev/laravel-eloquent-pruning.svg?style=flat-square)](https://packagist.org/packages/codenco-dev/laravel-eloquent-pruning)
[![Build Status](https://img.shields.io/travis/codenco-dev/laravel-eloquent-pruning/master.svg?style=flat-square)](https://travis-ci.org/codenco-dev/laravel-eloquent-pruning)
[![Quality Score](https://img.shields.io/scrutinizer/g/codenco-dev/laravel-eloquent-pruning.svg?style=flat-square)](https://scrutinizer-ci.com/g/codenco-dev/laravel-eloquent-pruning)
[![Total Downloads](https://img.shields.io/packagist/dt/codenco-dev/laravel-eloquent-pruning.svg?style=flat-square)](https://packagist.org/packages/codenco-dev/laravel-eloquent-pruning)

This awesome package allows managing pruning of your eloquent model.  

## Installation

You can install the package via composer:

```bash
composer require codenco-dev/laravel-eloquent-pruning
```

## Configuration

We have several options that must be configure.

+ `pruning_column` - The name of the column that will be used to determine if a record should be pruned
+ `hours` - The hours count that will determine if a record should pruned relative to pruning_column and now
+ `with_delete_events` - If the value is true, the delete method of model will be call, allowing fire events. If the value is false, the delete action will be done with query builder, without event.
+ `chunk_size` - The size of delete query if with_delete_events is false


Each options for a model can be defined in the model file like this : 

 ``` php
     class MyModel extends Model
     {
         use Prunable;
     
         protected $fillable = ['id'];
     
         protected $hours = 1;
         protected $pruningColumn = 'updated_at';
         protected $chunkSize = 1000;
         protected $withDeleteEvents = false;
     
     }
 ```

If you need something more elaborate, you be able to overwrite, `Prunable` trait methods.

``` php
    class MyModel extends Model
    {
        use Prunable;
    
        protected $fillable = ['id'];
    
        public function getHours(): int
        {
            return 1;
        }
    
        public function getPruningColumn(): string
        {
            return 'created_at';
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
```
 
You can publish configuration file with this command line
```bash
php artisan vendor:publish --provider="CodencoDev\LaravelEloquentPruning\LaravelEloquentPruningServiceProvider" --tag="config"
```

In configuration file, you can manage default value for the Pruning Package. 
You must define models that will be affected by pruning.  
 
```php
    'models' => [
        App\MyModel::class,
        App\MySecondModel::class,
    ],
```


If some records can't be prune, with business logic, you can use this methods : 

If `with_delete_events` is false, the business logic must be put in `scopeCouldBePruned` like this

``` php
    /**
     * Scope that allows filter records for pruning.
     */
    public function scopeCouldBePruned(Builder $query): Builder
    {
        return $query->where('status','done');
    }
```

If `with_delete_events` is true, the business logic can be put in `scopeCouldBePruned` but also by overwrite `canBePruned` method like this

``` php
    /**
     * Define if the active record can be pruned, if the ProcessWithDeleteEvents is true.
     */
    public function canBePruned(): bool
    {
        //tests, extern call etc.
        return MyService::checkMyModelIsDeletable($this->id);
    }
```


## Usage

You can add global pruning on your schedule by modifying `app/Console/Kernel.php` like this for example

``` php
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('pruning:start')->hourly();
    }
```

If you want bypass model hour configuration, you can call this command with `hours` option like this : 
``` php
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('pruning:start --hours=48])->hourly();
    }
```
This call allows to prune all data created more than 48 hours ago.


Of course, you can use a schedule by model (or create a dedicated command if you want) : 

``` php
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function(){
            (new MyModel)->prune();
        })->daily();
    }
```



### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email dthomas@codenco.io instead of using the issue tracker.

## Credits

- [Dominic Thomas](https://github.com/codenco-dev)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).

## Inspiration
This package was inspired by laravel/telescope pruning. 