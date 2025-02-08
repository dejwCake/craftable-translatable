# Translatable

Translatable makes your content translatable in defined languages (locales). To sum up, the package:
- publishes a config, that defines locales (languages) used in your project,
- introduces a `HasTranslations` trait that makes your Eloquent model translatable (extending `spatie/laravel-translatable`),
- introduces a `WithTranslations` interface that marks your Eloquent model translatable, although it will work with trait also without this interface,
- introduces a `TranslatableFormRequest` class that you can use as a base class for your Request classes to extend from, which simplify the definition of the rules for translatable data.

You can find full documentation at https://docs.getcraftable.com/#/translatable

## Composer

To develop this package, you need to have composer installed. To run composer command use:

```shell
  docker compose run -it --rm test composer update
```

## Run tests

To run tests use this docker environment.

```shell
  docker compose run -it --rm test vendor/bin/phpunit -d pcov.enabled=1
```

To switch between postgresql and mariadb change in `docker-compose.yml` DB_CONNECTION environmental variable:

```git
- DB_CONNECTION: pgsql
+ DB_CONNECTION: mysql
```

## Run code analysis tools

To be sure, that your code is clean, you can run code analysis tools. To do this, run:

For composer normalization:
```shell
  docker compose run -it --rm php-qa composer normalize
```

For php compatibility:
```shell
  docker compose run -it --rm php-qa phpcs --standard=.phpcs.compatibility.xml --cache=.phpcs.cache
```

For code style:
```shell
  docker compose run -it --rm php-qa phpcs -s --colors --extensions=php
```

or to fix issues:

```shell
  docker compose run -it --rm php-qa phpcbf -s --colors --extensions=php
```

For static analysis:
```shell
  docker compose run -it --rm php-qa phpstan analyse --configuration=phpstan.neon
```

For mess detector:
```shell
  docker compose run -it --rm php-qa phpmd ./src,./install-stubs,./tests ansi phpmd.xml --suffixes php --baseline-file phpmd.baseline.xml
```
