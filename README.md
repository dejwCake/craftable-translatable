# Translatable

Translatable makes your content translatable in defined languages (locales). To sum up, the package:
- publishes a config, that defines locales (languages) used in your project,
- introduces a `HasTranslations` trait that makes your Eloquent model translatable (extending `spatie/laravel-translatable`),
- introduces a `TranslatableFormRequest` class that you can use as a base class for your Request classes to extend from, which simplify the definition of the rules for translatable data.

You can find full documentation at https://docs.getcraftable.com/#/translatable

## Run tests

To run tests use this docker environment.

```shell
  docker-compose run -it test vendor/bin/phpunit
```

To switch between postgresql and mariadb change in `docker-compose.yml` DB_CONNECTION environmental variable:

```git
- DB_CONNECTION: pgsql
+ DB_CONNECTION: mysql
```
