<?php

declare(strict_types=1);

namespace Brackets\Translatable\Tests;

use Brackets\Translatable\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    use HasTranslations;

    protected string $table = 'test_models';

    /** @var array<string> */
    protected array $guarded = [];

    public bool $timestamps = false;

    /** @var array<string> */
    public array $translatable = ['translatable_name'];
}
