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

    public function translatableRules($locale): array
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
