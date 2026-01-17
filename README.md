# Translatable

Translatable makes your content easily translatable into the locales (languages) you define. In short, the package:
- publishes a config file that defines the locales (languages) used in your project,
- provides a `HasTranslations` trait that makes your Eloquent model translatable (extending `spatie/laravel-translatable`),
- provides a `WithTranslations` interface that marks your Eloquent model as translatable (the trait will also work without this interface),
- provides a `TranslatableFormRequest` class you can use as a base for your form request classes, simplifying the definition of validation rules for translatable data.

## Documentation
You can find full documentation at https://docs.getcraftable.com/#/translatable

## How to develop this project

### Composer

Update dependencies:
```shell
docker compose run -it --rm test composer update
```

Composer normalization:
```shell
docker compose run -it --rm php-qa composer normalize
```

### Run tests

Run tests with pcov:
```shell
docker compose run -it --rm test ./vendor/bin/phpunit -d pcov.enabled=1
```

To switch between postgresql and mariadb change in `docker-compose.yml` DB_CONNECTION environmental variable:
```git
- DB_CONNECTION: pgsql
+ DB_CONNECTION: mysql
```

### Run code analysis tools (php-qa)

PHP compatibility:
```shell
docker compose run -it --rm php-qa phpcs --standard=.phpcs.compatibility.xml --cache=.phpcs.cache
```

Code style:
```shell
docker compose run -it --rm php-qa phpcs -s --colors --extensions=php
```

Fix style issues:
```shell
docker compose run -it --rm php-qa phpcbf -s --colors --extensions=php
```

Static analysis (phpstan):
```shell
docker compose run -it --rm php-qa phpstan analyse --configuration=phpstan.neon
```

Mess detector (phpmd):
```shell
docker compose run -it --rm php-qa phpmd ./src,./install-stubs,./tests ansi phpmd.xml --suffixes php --baseline-file phpmd.baseline.xml
```