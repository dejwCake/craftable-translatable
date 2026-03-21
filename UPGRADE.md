# Upgrade guide v1 to v2

## Requirements

- PHP `^8.5` (was `^8.2`)
- Laravel `^13.0` (was `^12.0`)
- spatie/laravel-translatable `^6.13` (was `^6.11.4`)

## Breaking changes

### Facade removed

The `Brackets\Translatable\Facades\Translatable` facade has been removed. Use dependency injection instead:

```php
// v1 — facade (removed)
use Brackets\Translatable\Facades\Translatable;
Translatable::getLocales();

// v2 — dependency injection
use Brackets\Translatable\Translatable;
public function __construct(private readonly Translatable $translatable) {}
$this->translatable->getLocales();
```

The `AliasLoader` registration for the `Translatable` alias has also been removed from the service provider.

### TranslatableFormRequest now requires constructor injection

`TranslatableFormRequest` no longer uses `app()` helper internally. It receives `Translatable` via constructor injection:

```php
// v1 — no constructor, used app() internally
class MyRequest extends TranslatableFormRequest
{
    // just worked
}

// v2 — Translatable is injected via constructor
// Laravel's container handles this automatically for requests resolved through routes.
// If you instantiate manually (e.g. in tests), pass Translatable explicitly:
$request = new MyRequest($translatable);
```

If you override the constructor in a subclass, you must accept and pass `Translatable` to `parent::__construct()`.

### Config file location changed

The config file moved from `install-stubs/config/translatable.php` to `config/translatable.php`. If you have already published the config, no action is needed. If you re-publish:

```shell
php artisan vendor:publish --tag=config --provider="Brackets\Translatable\TranslatableServiceProvider" --force
```

### Classes are now final

The following classes are now `final` and cannot be extended:
- `Translatable`
- `TranslatableServiceProvider`
- `TranslatableProvider`
- `ViewComposerProvider`
