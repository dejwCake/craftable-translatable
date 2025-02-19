<?php

declare(strict_types=1);

namespace Brackets\Translatable\Tests;

use Brackets\Translatable\Http\Requests\TranslatableFormRequest;

class TestRequest extends TranslatableFormRequest
{
    // define all the regular rules
    public function untranslatableRules(): array
    {
        return [
            'published_at' => ['required', 'datetime'],
        ];
    }

    /**
     * define all the rules for translatable columns
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function translatableRules(string $locale): array
    {
        return [
            'title' => ['required', 'string'],
            'body' => ['nullable', 'text'],
        ];
    }
}
