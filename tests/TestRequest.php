<?php

namespace Brackets\Translatable\Tests;

use Brackets\Translatable\TranslatableFormRequest;

class TestRequest extends TranslatableFormRequest
{
    // define all the regular rules
    public function untranslatableRules(): array
    {
        return [
            'published_at' => ['required', 'datetime'],
        ];
    }

    // define all the rules for translatable columns
    public function translatableRules($locale): array
    {
        return [
            'title' => ['required', 'string'],
            'body' => ['nullable', 'text'],
        ];
    }
}
