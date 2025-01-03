<?php

namespace Brackets\Translatable\Tests\Feature;

use Brackets\Translatable\Tests\TestCase;

class TranslatableModelTest extends TestCase
{
    public function testModelByDefaultWorksOnlyWithDefaultLocale(): void
    {
        self::assertEquals('EN Name', $this->testModel->translatable_name);
        self::assertEquals([
            'id' => 1,
            'translatable_name' => 'EN Name',
            'regular_name' => 'Regular Name',
        ], $this->testModel->toArray());
    }

    public function testYouCanSetLocale(): void
    {
        self::assertEquals('en', $this->testModel->getLocale());
        $this->testModel->setLocale('fr');
        self::assertEquals('fr', $this->testModel->getLocale());
    }

    public function testYouCanChangeLocaleModelWorksWith(): void
    {
        $this->testModel->setLocale('fr');
        self::assertEquals('FR Name', $this->testModel->translatable_name);
        self::assertEquals([
            'id' => 1,
            'translatable_name' => 'FR Name',
            'regular_name' => 'Regular Name',
        ], $this->testModel->toArray());
        self::assertEquals(json_encode([
            'id' => 1,
            'translatable_name' => 'FR Name',
            'regular_name' => 'Regular Name',
        ]), $this->testModel->toJson());
    }

    public function testChangingLocaleDoesNotAffectOnAllLocalesMethods(): void
    {
        $sameOutput = [
            'id' => 1,
            'translatable_name' => [
                'en' => 'EN Name',
                'de' => 'DE Name',
                'fr' => 'FR Name',
            ],
            'regular_name' => 'Regular Name',
        ];

        self::assertEquals($sameOutput, $this->testModel->toArrayAllLocales());
        self::assertEquals(json_encode($sameOutput), $this->testModel->toJsonAllLocales());

        $this->testModel->setLocale('fr');

        self::assertEquals($sameOutput, $this->testModel->toArrayAllLocales());
        self::assertEquals(json_encode($sameOutput), $this->testModel->toJsonAllLocales());
    }
}
