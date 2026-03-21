<?php

declare(strict_types=1);

namespace Brackets\Translatable\Tests\Feature\Http\Requests\TranslatableFormRequest;

use Brackets\Translatable\Tests\TestCase;
use Illuminate\Support\Collection;

final class DefineRequiredLocalesTest extends TestCase
{
    public function testDefaultRequiredLocalesReturnsAllLocales(): void
    {
        self::assertEquals(
            new Collection(['en', 'de', 'fr']),
            $this->testRequest->defineRequiredLocales(),
        );
    }

    public function testCustomRequiredLocalesOnlyMarksSpecifiedAsRequired(): void
    {
        self::assertEquals(
            new Collection(['en', 'de']),
            $this->testRequestWithRequiredLocales->defineRequiredLocales(),
        );
    }
}
