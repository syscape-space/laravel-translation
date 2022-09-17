# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/syscape-space/laravel-translation.svg?style=flat-square)](https://packagist.org/packages/syscape-space/laravel-translation)
[![Total Downloads](https://img.shields.io/packagist/dt/syscape-space/laravel-translation.svg?style=flat-square)](https://packagist.org/packages/syscape-space/laravel-translation)
![GitHub Actions](https://github.com/syscape-space/laravel-translation/actions/workflows/main.yml/badge.svg)

A Laravel package for model attributes translations
## Installation

You can install the package via composer:

1. `composer require anlutro/l4-settings`
2. publish the migration to create the media table by running `php artisan vendor:publish --provider="SyscapeSpace\LaravelTranslation\LaravelTranslationServiceProvider" --tag="migrations"`.

## Usage

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SyscapeSpace\LaravelTranslation\Traits\hasTranslation;

class Post extends Model
{
    use HasFactory, HasTranslation;
    protected $fillable = [
        'title',
        'body',
    ];

    public $translationAttributes = [
        'title',
        'body',
    ];

    public function getTitleAttribute($value)
    {
        // locale is optional, if not set the current locale will be used
        $locale = 'en';
        // return the translated value
        return $this->getTranslation('title',$locale);
    }

    public function getBodyAttribute($value)
    {
        // locale is optional, if not set the current locale will be used
        $locale = 'en';
        // return the translated value
        return $this->getTranslation('body',$locale);
    }

}
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email ahmedalmory02@gmail.com instead of using the issue tracker.

## Credits

-   [Ahmed Almory](https://github.com/ahmedalmory)
-   [Ahmed Tofaha](https://github.com/ahmedtofaha10)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

