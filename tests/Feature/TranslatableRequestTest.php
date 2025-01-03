<?php

declare(strict_types=1);

namespace Brackets\Translatable\Tests\Feature;

use Brackets\Translatable\Tests\TestCase;

class TranslatableRequestTest extends TestCase
{
    public function testRequestCanHaveTranslatableColumns(): void
    {
        self::assertEquals([
            'published_at' => ['required', 'datetime'],
            'title.en' => ['required', 'string'],
            'title.de' => ['required', 'string'],
            'title.fr' => ['required', 'string'],
            'body.en' => ['nullable', 'text'],
            'body.de' => ['nullable', 'text'],
            'body.fr' => ['nullable', 'text'],
        ], $this->testRequest->rules());
    }

    public function testRequestCanOverrideRequiredLocales(): void
    {
        self::assertEquals([
            'published_at' => ['required', 'datetime'],
            'title.en' => ['required', 'string'],
            'title.de' => ['required', 'string'],
            'title.fr' => ['string', 'nullable'],
            'body.en' => ['nullable', 'text'],
            'body.de' => ['nullable', 'text'],
            'body.fr' => ['nullable', 'text'],
        ], $this->testRequestWithRequiredLocales->rules());
    }
}
