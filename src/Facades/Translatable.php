<?php

namespace Brackets\Translatable\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Brackets\Translatable\Translatable
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
