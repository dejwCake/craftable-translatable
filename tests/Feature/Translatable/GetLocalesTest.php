<?php

declare(strict_types=1);

namespace Brackets\Translatable\Tests\Feature\Translatable;

use Brackets\Translatable\Tests\TestCase;
use Brackets\Translatable\Translatable;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Support\Collection;

final class GetLocalesTest extends TestCase
{
    public function testGetLocalesReturnsConfiguredLocales(): void
    {
        $translatable = $this->app->make(Translatable::class);
        self::assertEquals(new Collection(['en', 'de', 'fr']), $translatable->getLocales());
    }

    public function testGetLocalesHandlesNestedArrayConfig(): void
    {
        $config = $this->app->make(Config::class);
        $config->set('translatable.locales', ['en', 'de' => ['DE', 'AT']]);

        $translatable = $this->app->make(Translatable::class);
        self::assertEquals(['en', 'de'], $translatable->getLocales()->values()->toArray());
    }

    public function testGetLocalesReturnsEmptyCollectionWhenNoLocalesConfigured(): void
    {
        $config = $this->app->make(Config::class);
        $config->set('translatable.locales', []);

        $translatable = $this->app->make(Translatable::class);
        self::assertEquals(new Collection(), $translatable->getLocales());
    }
}
