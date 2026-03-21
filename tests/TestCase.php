<?php

declare(strict_types=1);

namespace Brackets\Translatable\Tests;

use Brackets\Translatable\Translatable;
use Brackets\Translatable\TranslatableServiceProvider;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Support\Env;
use Orchestra\Testbench\TestCase as Orchestra;
use Override;

use function assert;

abstract class TestCase extends Orchestra
{
    protected TestModel $testModel;

    protected TestRequest $testRequest;

    protected TestRequestWithRequiredLocales $testRequestWithRequiredLocales;

    #[Override]
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);

        $this->testModel = TestModel::first();
        $translatable = $this->app->make(Translatable::class);
        $this->testRequest = new TestRequest($translatable);
        $this->testRequestWithRequiredLocales = new TestRequestWithRequiredLocales($translatable);
    }

    /**
     * @param Application $app
     * @return array<class-string>
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    protected function getPackageProviders($app): array
    {
        return [
            TranslatableServiceProvider::class,
        ];
    }

    /**
     * @param Application $app
     */
    #[Override]
    protected function getEnvironmentSetUp($app): void
    {
        $config = $app->make(Config::class);

        if (Env::get('DB_CONNECTION') === 'pgsql') {
            $config->set('database.default', 'pgsql');
            $config->set('database.connections.pgsql', [
                'driver' => 'pgsql',
                'host' => 'pgsql',
                'port' => '5432',
                'database' => Env::get('DB_DATABASE', 'laravel'),
                'username' => Env::get('DB_USERNAME', 'root'),
                'password' => Env::get('DB_PASSWORD', 'bestsecret'),
                'charset' => 'utf8',
                'prefix' => '',
                'schema' => 'public',
                'sslmode' => 'prefer',
            ]);
        } else if (Env::get('DB_CONNECTION') === 'mysql') {
            $config->set('database.default', 'mysql');
            $config->set('database.connections.mysql', [
                'driver' => 'mysql',
                'host' => 'mysql',
                'port' => '3306',
                'database' => Env::get('DB_DATABASE', 'laravel'),
                'username' => Env::get('DB_USERNAME', 'root'),
                'password' => Env::get('DB_PASSWORD', 'bestsecret'),
                'charset' => 'utf8',
                'prefix' => '',
                'schema' => 'public',
                'sslmode' => 'prefer',
            ]);
        } else {
            $config->set('database.default', 'sqlite');
            $config->set('database.connections.sqlite', [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]);
        }

        $config->set('app.key', '6rE9Nz59bGRbeMATftriyQjrpF7DcOQm');

        $config->set('translatable.locales', ['en', 'de', 'fr']);
    }

    protected function setUpDatabase(Application $app): void
    {
        $schema = $app->make('db')->connection()->getSchemaBuilder();
        assert($schema instanceof Builder);
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
