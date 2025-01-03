<?php

namespace Brackets\Translatable\Tests;

use Brackets\Translatable\TranslatableFormRequest;
use Illuminate\Support\Collection;

class TestRequestWithRequiredLocales extends TranslatableFormRequest
{
    public function untranslatableRules(): array
    {
        return [
            'published_at' => ['required', 'datetime'],
        ];
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function translatableRules(string $locale): array
    {
        return [
            'title' => ['required', 'string'],
            'body' => ['nullable', 'text'],
        ];
    }

    public function defineRequiredLocales() : Collection
    {
        return new Collection(['en', 'de']);
    }
}
