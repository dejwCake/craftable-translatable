<?php

declare(strict_types=1);

namespace Brackets\Translatable;

use Brackets\Translatable\Facades\Translatable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class TranslatableFormRequest extends FormRequest
{
    /**
     * Define what locales should be required in store/update requests
     *
     * By default all locales are required
     */
    public function defineRequiredLocales(): Collection
    {
        return Translatable::getLocales();
    }

    /**
     * @return array<string, string>
     */
    public function rules(): array
    {
        $standardRules = new Collection($this->untranslatableRules());

        $rules = $this->prepareLocalesForRules()->flatMap(fn ($locale) => (new Collection(
            $this->translatableRules($locale['locale']),
        ))->mapWithKeys(static function ($rule, $ruleKey) use ($locale) {
                if (!$locale['required']) {
                    // TODO add support for rules defined via custom Rule classes

                    $key = array_search('required', $rule, true);
                    if (is_array($rule) && $key !== false) {
                        unset($rule[$key]);
                        array_push($rule, 'nullable');
                    } elseif (is_string($rule)) {
                        $rule = str_replace('required', 'nullable', $rule);
                    }
                }

                return [$ruleKey . '.' . $locale['locale'] => is_array($rule) ? array_values($rule) : $rule];
        }))->merge($standardRules);

        return $rules->toArray();
    }

    public function untranslatableRules(): array
    {
        return [];
    }

    /** @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter */
    public function translatableRules(string $locale): array
    {
        return [];
    }

    /**
     * @return Collection<array<string, string|bool>>
     */
    private function prepareLocalesForRules(): Collection
    {
        $required = $this->defineRequiredLocales();

        return Translatable::getLocales()->map(static fn ($locale) => [
                'locale' => $locale,
                'required' => $required->contains($locale),
            ]);
    }
}
