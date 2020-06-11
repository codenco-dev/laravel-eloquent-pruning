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

You can publish configuration file with this command line
```bash
php artisan vendor:publish --provider="CodencoDev\LaravelEloquentPruning\LaravelEloquentPruningServiceProvider" --tag="config"
```

In configuration file, you can manage default value for the Pruning Package.

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

## Usage

You can add global pruning on your schedule by modifying `app/Console/Kernel.php` like this for example

``` php
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('pruning:start')->hourly();
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
This package is inspired by laravel/telescope pruning. 