<?php

declare(strict_types=1);

namespace Brackets\Translatable\Tests\Feature\Http\Requests\TranslatableFormRequest;

use Brackets\Translatable\Http\Requests\TranslatableFormRequest;
use Brackets\Translatable\Tests\TestCase;
use Brackets\Translatable\Translatable;
use Illuminate\Support\Collection;
use Override;

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
        $request = new class ($translatable) extends TranslatableFormRequest {
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

    public function testRulesReplacesRequiredWithNullableInStringRulesForNonRequiredLocales(): void
    {
        $translatable = $this->app->make(Translatable::class);
        $request = new class ($translatable) extends TranslatableFormRequest {
            /** @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter */
            #[Override]
            public function translatableRules(string $locale): array
            {
                return [
                    'title' => 'required|string',
                ];
            }

            #[Override]
            public function defineRequiredLocales(): Collection
            {
                return new Collection(['en', 'de']);
            }
        };

        self::assertEquals([
            'title.en' => 'required|string',
            'title.de' => 'required|string',
            'title.fr' => 'nullable|string',
        ], $request->rules());
    }

    public function testRulesReturnsEmptyWhenNoRulesDefined(): void
    {
        $translatable = $this->app->make(Translatable::class);
        $request = new TranslatableFormRequest($translatable);

        self::assertEquals([], $request->rules());
    }
}
