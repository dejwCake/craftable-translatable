<?php

declare(strict_types=1);

namespace Brackets\Translatable\Tests;

use Brackets\Translatable\Http\Requests\TranslatableFormRequest;
use Override;

class TestRequest extends TranslatableFormRequest
{
    // define all the regular rules
    #[Override]
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
    #[Override]
    public function translatableRules(string $locale): array
    {
        return [
            'title' => ['required', 'string'],
            'body' => ['nullable', 'text'],
        ];
    }
}
