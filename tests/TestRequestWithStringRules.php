<?php

declare(strict_types=1);

namespace Brackets\Translatable\Tests;

use Brackets\Translatable\Http\Requests\TranslatableFormRequest;
use Override;

class TestRequestWithStringRules extends TranslatableFormRequest
{
    #[Override]
    public function translatableRules(string $locale): array
    {
        return [
            'title' => 'required|string',
        ];
    }
}
