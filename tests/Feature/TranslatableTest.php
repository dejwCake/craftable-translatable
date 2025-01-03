<?php

declare(strict_types=1);

namespace Brackets\Translatable\Tests\Feature;

use Brackets\Translatable\Tests\TestCase;
use Brackets\Translatable\Translatable;
use Illuminate\Support\Collection;

class TranslatableTest extends TestCase
{
    public function testPackageCanDefineUsedLocales(): void
    {
        $translatable = app(Translatable::class);
        self::assertEquals(new Collection(['en', 'de', 'fr']), $translatable->getLocales());
    }
}
