<?php

declare(strict_types=1);

namespace Brackets\Translatable\Traits;

use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Spatie\Translatable\HasTranslations as ParentHasTranslations;

trait HasTranslations
{
    use ParentHasTranslations;

    protected string $locale;

    /**
     * Get an attribute from the model.
     *
     * @param string $key
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingNativeTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingAnyTypeHint
     */
    public function getAttributeValue($key)
    {
        if (!$this->isTranslatableAttribute($key)) {
            return parent::getAttributeValue($key);
        }

        return $this->getTranslation($key, $this->getLocale());
    }

    /**
     * Set the locale of the model
     *
     * This locale would be used when working with translated attributes
     */
    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    /**
     * Get current locale of the model
     */
    public function getLocale(): string
    {
        return $this->locale ?? App::getLocale();
    }

    /**
     * Convert the model instance to an array.
     *
     * By default, translations of only current locale of the model of each translated attribute is returned
     */
    public function toArray(): array
    {
        $array = parent::toArray();
        $arrayTranslatable = (new Collection($this->getTranslatableAttributes()))->mapWithKeys(
            fn ($attribute) => [$attribute => $this->getAttributeValue($attribute)],
        );

        return array_merge($array, $arrayTranslatable->toArray());
    }

    /**
     * Convert the model instance to an array.
     *
     * Translated columns are returned as arrays.
     */
    public function toArrayAllLocales(): array
    {
        return parent::toArray();
    }

    /**
     * Convert the model instance to JSON.
     *
     * By default, translations of only current locale of the model of each translated attribute is returned
     *
     * @param int $options
     * @throws JsonEncodingException
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     */
    public function toJson($options = 0): string
    {
        return parent::toJson($options);
    }

    /**
     * Convert the model instance to JSON.
     *
     * Translated columns are returned as arrays.
     *
     * @throws JsonEncodingException
     */
    public function toJsonAllLocales(int $options = 0): string
    {
        $json = json_encode($this->toArrayAllLocales(), $options);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw JsonEncodingException::forModel($this, json_last_error_msg());
        }

        return $json;
    }
}
