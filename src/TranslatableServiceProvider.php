<?php

declare(strict_types=1);

namespace Brackets\Translatable;

use Brackets\Translatable\Providers\TranslatableProvider;
use Brackets\Translatable\Providers\ViewComposerProvider;
use Illuminate\Support\ServiceProvider;
use Override;

final class TranslatableServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publish();
        }
    }

    #[Override]
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/translatable.php', 'translatable');

        $this->app->register(ViewComposerProvider::class);
        $this->app->register(TranslatableProvider::class);
    }

    private function publish(): void
    {
        $this->publishes([
            __DIR__ . '/../config/translatable.php' => config_path('translatable.php'),
        ], 'config');
    }
}
