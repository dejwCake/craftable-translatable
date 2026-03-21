<?php

declare(strict_types=1);

namespace Brackets\Translatable\Tests\Feature\Traits\HasTranslations;

use Brackets\Translatable\Tests\TestCase;

final class SetAndGetLocaleTest extends TestCase
{
    public function testGetLocaleDefaultsToAppLocale(): void
    {
        self::assertEquals('en', $this->testModel->getLocale());
    }

    public function testSetLocaleChangesModelLocale(): void
    {
        $this->testModel->setLocale('de');
        self::assertEquals('de', $this->testModel->getLocale());
    }

    public function testGetLocaleReturnsSetLocale(): void
    {
        $this->testModel->setLocale('fr');
        self::assertEquals('fr', $this->testModel->getLocale());
    }
}
