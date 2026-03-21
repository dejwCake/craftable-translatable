<?php

declare(strict_types=1);

namespace Brackets\Translatable\Tests\Feature\Traits\HasTranslations;

use Brackets\Translatable\Tests\TestCase;

final class ToJsonTest extends TestCase
{
    public function testToJsonReturnsCurrentLocaleAsJson(): void
    {
        self::assertEquals(json_encode([
            'id' => 1,
            'translatable_name' => 'EN Name',
            'regular_name' => 'Regular Name',
        ]), $this->testModel->toJson());
    }

    public function testToJsonReflectsLocaleChange(): void
    {
        $this->testModel->setLocale('fr');
        self::assertEquals(json_encode([
            'id' => 1,
            'translatable_name' => 'FR Name',
            'regular_name' => 'Regular Name',
        ]), $this->testModel->toJson());
    }

    public function testToJsonAllLocalesReturnsAllTranslationsAsJson(): void
    {
        self::assertEquals(json_encode([
            'id' => 1,
            'translatable_name' => [
                'en' => 'EN Name',
                'de' => 'DE Name',
                'fr' => 'FR Name',
            ],
            'regular_name' => 'Regular Name',
        ]), $this->testModel->toJsonAllLocales());
    }

    public function testToJsonAllLocalesIsUnaffectedByLocaleChange(): void
    {
        $expected = json_encode([
            'id' => 1,
            'translatable_name' => [
                'en' => 'EN Name',
                'de' => 'DE Name',
                'fr' => 'FR Name',
            ],
            'regular_name' => 'Regular Name',
        ]);

        self::assertEquals($expected, $this->testModel->toJsonAllLocales());

        $this->testModel->setLocale('fr');

        self::assertEquals($expected, $this->testModel->toJsonAllLocales());
    }
}
