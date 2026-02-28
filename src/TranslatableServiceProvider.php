<?php

declare(strict_types=1);

namespace Brackets\Translatable;

use Brackets\Translatable\Facades\Translatable;
use Brackets\Translatable\Providers\TranslatableProvider;
use Brackets\Translatable\Providers\ViewComposerProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class TranslatableServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publish();
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/translatable.php', 'translatable');

        $this->app->register(ViewComposerProvider::class);
        $this->app->register(TranslatableProvider::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('Translatable', Translatable::class);
    }

    private function publish(): void
    {
        $this->publishes([
            __DIR__ . '/../config/translatable.php' => config_path('translatable.php'),
        ], 'config');
    }
}
