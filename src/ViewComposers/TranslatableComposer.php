<?php

declare(strict_types=1);

namespace Brackets\Translatable\ViewComposers;

use Brackets\Translatable\Translatable;
use Illuminate\Contracts\View\View;

final readonly class TranslatableComposer
{
    public function __construct(private Translatable $translatable)
    {
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with('locales', $this->translatable->getLocales());
    }
}
