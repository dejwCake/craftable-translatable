<?php

namespace Brackets\Translatable\ViewComposers;

use Brackets\Translatable\Facades\Translatable;
use Illuminate\Contracts\View\View;

class TranslatableComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with('locales', Translatable::getLocales());
    }
}
