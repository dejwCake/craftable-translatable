<?php

declare(strict_types=1);

namespace Brackets\Translatable\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Brackets\Translatable\Translatable
 * @method static Collection getLocales()
 * @deprecated We do not want to support Facades anymore. Please use dependency injection instead.
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
