<?php

declare(strict_types=1);

namespace Brackets\Translatable\Tests;

use Brackets\Translatable\TranslatableServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected TestModel $testModel;

    protected TestRequest $testRequest;

    protected TestRequestWithRequiredLocales $testRequestWithRequiredLocales;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);

        $this->testModel = TestModel::first();
        $this->testRequest = new TestRequest();
        $this->testRequestWithRequiredLocales = new TestRequestWithRequiredLocales();
    }

    /**
     * @param Application $app
     * @return array<class-string>
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    protected function getPackageProviders($app): array
    {
        return [
            TranslatableServiceProvider::class,
        ];
    }

    /**
     * @param Application $app
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     */
    protected function getEnvironmentSetUp($app): void
    {
        if (env('DB_CONNECTION') === 'pgsql') {
            $app['config']->set('database.default', 'pgsql');
            $app['config']->set('database.connections.pgsql', [
                'driver' => 'pgsql',
                'host' => 'pgsql',
                'port' => '5432',
                'database' => env('DB_DATABASE', 'laravel'),
                'username' => env('DB_USERNAME', 'root'),
                'password' => env('DB_PASSWORD', 'bestsecret'),
                'charset' => 'utf8',
                'prefix' => '',
                'schema' => 'public',
                'sslmode' => 'prefer',
            ]);
        } else if (env('DB_CONNECTION') === 'mysql') {
            $app['config']->set('database.default', 'mysql');
            $app['config']->set('database.connections.mysql', [
                'driver' => 'mysql',
                'host' => 'mysql',
                'port' => '3306',
                'database' => env('DB_DATABASE', 'laravel'),
                'username' => env('DB_USERNAME', 'root'),
                'password' => env('DB_PASSWORD', 'bestsecret'),
                'charset' => 'utf8',
                'prefix' => '',
                'schema' => 'public',
                'sslmode' => 'prefer',
            ]);
        } else {
            $app['config']->set('database.default', 'sqlite');
            $app['config']->set('database.connections.sqlite', [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]);
        }

        $app['config']->set('app.key', '6rE9Nz59bGRbeMATftriyQjrpF7DcOQm');

        $app['config']->set('translatable.locales', ['en', 'de', 'fr']);
    }

    protected function setUpDatabase(Application $app): void
    {
        $schema = $app['db']->connection()->getSchemaBuilder();
        \assert($schema instanceof Builder);
        $schema->dropIfExists('test_models');
        $schema->create('test_models', static function (Blueprint $table): void {
            $table->increments('id');
            $table->text('translatable_name');
            $table->string('regular_name');
        });

        TestModel::create([
            'translatable_name' => [
                'en' => 'EN Name',
                'de' => 'DE Name',
                'fr' => 'FR Name',
            ],
            'regular_name' => 'Regular Name',
        ]);
    }
}
