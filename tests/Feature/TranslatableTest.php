<?php

namespace Brackets\Translatable\Tests\Feature;

use Brackets\Translatable\Tests\TestCase;
use Brackets\Translatable\Translatable;

class TranslatableTest extends TestCase
{
    public function testPackageCanDefineUsedLocales(): void
    {
        $translatable = app(Translatable::class);
        self::assertEquals(collect(['en', 'de', 'fr']), $translatable->getLocales());
    }
}
