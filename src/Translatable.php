<?php

declare(strict_types=1);

namespace Brackets\Translatable;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Support\Collection;

readonly class Translatable
{
    public function __construct(private Config $config)
    {
    }

    /**
     * Attempt to get all locales.
     */
    public function getLocales(): Collection
    {
        return (new Collection((array) $this->config->get('translatable.locales')))->map(
            static fn ($val, $key) => is_array($val) ? $key : $val,
        );
    }
}
