<?php

namespace Brackets\Translatable;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class Translatable
{
    /**
     * Attempt to get all locales.
     */
    public function getLocales(): Collection
    {
        return (new Collection((array) Config::get('translatable.locales')))->map(static function ($val, $key) {
            return is_array($val) ? $key : $val;
        });
    }
}
