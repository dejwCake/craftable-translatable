<?php

declare(strict_types=1);

namespace Brackets\Translatable\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Brackets\Translatable\Translatable
 * @method static Collection getLocales()
 */
class Translatable extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingNativeTypeHint
     */
    protected static function getFacadeAccessor()
    {
        return 'translatable';
    }
}
