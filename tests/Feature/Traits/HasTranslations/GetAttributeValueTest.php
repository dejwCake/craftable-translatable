<?php

declare(strict_types=1);

namespace Brackets\Translatable\Tests\Feature\Traits\HasTranslations;

use Brackets\Translatable\Tests\TestCase;

final class GetAttributeValueTest extends TestCase
{
    public function testReturnsTranslatedValueForCurrentLocale(): void
    {
        self::assertEquals('EN Name', $this->testModel->translatable_name);
    }

    public function testReturnsRegularValueForNonTranslatableAttribute(): void
    {
        self::assertEquals('Regular Name', $this->testModel->regular_name);
    }

    public function testReturnsTranslatedValueAfterLocaleChange(): void
    {
        $this->testModel->setLocale('de');
        self::assertEquals('DE Name', $this->testModel->translatable_name);
    }
}
