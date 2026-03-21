<?php

declare(strict_types=1);

namespace Brackets\Translatable\Tests\Feature\ViewComposers;

use Brackets\Translatable\Tests\TestCase;
use Brackets\Translatable\Translatable;
use Brackets\Translatable\ViewComposers\TranslatableComposer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

final class TranslatableComposerTest extends TestCase
{
    public function testComposeAddsLocalesToView(): void
    {
        $translatable = $this->app->make(Translatable::class);
        $composer = new TranslatableComposer($translatable);

        $view = View::make('welcome');
        $composer->compose($view);

        self::assertEquals(new Collection(['en', 'de', 'fr']), $view->getData()['locales']);
    }
}
