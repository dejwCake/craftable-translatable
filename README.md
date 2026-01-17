# Translatable

Translatable makes your content translatable in defined languages (locales). To sum up, the package:
- publishes a config, that defines locales (languages) used in your project,
- introduces a `HasTranslations` trait that makes your Eloquent model translatable (extending `spatie/laravel-translatable`),
- introduces a `WithTranslations` interface that marks your Eloquent model translatable, although it will work with trait also without this interface,
- introduces a `TranslatableFormRequest` class that you can use as a base class for your Request classes to extend from, which simplify the definition of the rules for translatable data.

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