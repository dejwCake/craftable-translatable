<?php

declare(strict_types=1);

namespace Brackets\Translatable\Tests;

use Brackets\Translatable\Http\Requests\TranslatableFormRequest;
use Illuminate\Support\Collection;
use Override;

class TestRequestWithRequiredLocales extends TranslatableFormRequest
{
    #[Override]
    public function untranslatableRules(): array
    {
        return [
            'published_at' => ['required', 'datetime'],
        ];
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function translatableRules(string $locale): array
    {
        return [
            'title' => ['required', 'string'],
            'body' => ['nullable', 'text'],
        ];
    }

    #[Override]
    public function defineRequiredLocales(): Collection
    {
        return new Collection(['en', 'de']);
    }
}
