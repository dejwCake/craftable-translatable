<?php

declare(strict_types=1);

namespace Brackets\Translatable\Models;

interface WithTranslations
{
    public function getLocale(): string;
}
