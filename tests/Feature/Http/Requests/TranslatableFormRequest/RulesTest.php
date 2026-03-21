<?php

declare(strict_types=1);

namespace Brackets\Translatable\Tests\Feature\Http\Requests\TranslatableFormRequest;

use Brackets\Translatable\Tests\TestCase;
use Brackets\Translatable\Translatable;

final class RulesTest extends TestCase
{
    public function testRulesExpandsTranslatableColumnsForAllLocales(): void
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

    public function testRulesReplacesRequiredWithNullableForNonRequiredLocales(): void
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

    public function testRulesHandlesStringRules(): void
    {
        self::assertEquals([
            'title.en' => 'required|string',
            'title.de' => 'required|string',
            'title.fr' => 'required|string',
        ], $this->testRequestWithStringRules->rules());
    }

    public function testRulesReturnsOnlyUntranslatableRulesWhenNoTranslatableRules(): void
    {
        $translatable = $this->app->make(Translatable::class);
        $request = new class ($translatable) extends \Brackets\Translatable\Http\Requests\TranslatableFormRequest {
            public function untranslatableRules(): array
            {
                return [
                    'published_at' => ['required', 'datetime'],
                ];
            }
        };

        self::assertEquals([
            'published_at' => ['required', 'datetime'],
        ], $request->rules());
    }

    public function testRulesReturnsEmptyWhenNoRulesDefined(): void
    {
        $translatable = $this->app->make(Translatable::class);
        $request = new \Brackets\Translatable\Http\Requests\TranslatableFormRequest($translatable);

        self::assertEquals([], $request->rules());
    }
}
