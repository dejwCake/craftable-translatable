<?php

declare(strict_types=1);

namespace Brackets\Translatable\Providers;

use Brackets\Translatable\ViewComposers\TranslatableComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function boot(): void
    {
        View::composer('*', TranslatableComposer::class);
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        //do nothing
    }
}
