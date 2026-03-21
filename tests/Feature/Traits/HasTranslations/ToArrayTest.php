<?php

declare(strict_types=1);

namespace Brackets\Translatable\Tests\Feature\Traits\HasTranslations;

use Brackets\Translatable\Tests\TestCase;

final class ToArrayTest extends TestCase
{
    public function testToArrayReturnsCurrentLocaleTranslations(): void
    {
        self::assertEquals([
            'id' => 1,
            'translatable_name' => 'EN Name',
            'regular_name' => 'Regular Name',
        ], $this->testModel->toArray());
    }

    public function testToArrayReflectsLocaleChange(): void
    {
        $this->testModel->setLocale('fr');
        self::assertEquals([
            'id' => 1,
            'translatable_name' => 'FR Name',
            'regular_name' => 'Regular Name',
        ], $this->testModel->toArray());
    }

    public function testToArrayAllLocalesReturnsAllTranslations(): void
    {
        self::assertEquals([
            'id' => 1,
            'translatable_name' => [
                'en' => 'EN Name',
                'de' => 'DE Name',
                'fr' => 'FR Name',
            ],
            'regular_name' => 'Regular Name',
        ], $this->testModel->toArrayAllLocales());
    }

    public function testToArrayAllLocalesIsUnaffectedByLocaleChange(): void
    {
        $expected = [
            'id' => 1,
            'translatable_name' => [
                'en' => 'EN Name',
                'de' => 'DE Name',
                'fr' => 'FR Name',
            ],
            'regular_name' => 'Regular Name',
        ];

        self::assertEquals($expected, $this->testModel->toArrayAllLocales());

        $this->testModel->setLocale('fr');

        self::assertEquals($expected, $this->testModel->toArrayAllLocales());
    }
}
