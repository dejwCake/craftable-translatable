<?php

declare(strict_types=1);

namespace Brackets\Translatable\Http\Requests;

use Brackets\Translatable\Translatable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class TranslatableFormRequest extends FormRequest
{
    /** @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint */
    public function __construct(
        private readonly Translatable $translatable,
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null,
    ) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    /**
     * Define what locales should be required in store/update requests
     *
     * By default, all locales are required
     */
    public function defineRequiredLocales(): Collection
    {
        return $this->translatable->getLocales();
    }

    /**
     * @return array<string, string>
     */
    public function rules(): array
    {
        $standardRules = new Collection($this->untranslatableRules());

        $rules = $this->prepareLocalesForRules()->flatMap(fn (array $locale) => (new Collection(
            $this->translatableRules($locale['locale']),
        ))->mapWithKeys(static function (array|string $rule, int|string $ruleKey) use ($locale) {
            if (!$locale['required']) {
                // TODO add support for rules defined via custom Rule classes

                if (is_array($rule)) {
                    $key = array_search('required', $rule, true);
                    if ($key !== false) {
                        unset($rule[$key]);
                        array_push($rule, 'nullable');
                    }
                } elseif (is_string($rule)) {
                    $rule = str_replace('required', 'nullable', $rule);
                }
            }

                return [
                    sprintf('%s.%s', $ruleKey, $locale['locale'])
                        => is_array($rule) ? array_values($rule) : $rule,
                ];
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
    protected function prepareLocalesForRules(): Collection
    {
        $required = $this->defineRequiredLocales();

        return $this->translatable->getLocales()->map(static fn (string $locale) => [
                'locale' => $locale,
                'required' => $required->contains($locale),
            ]);
    }
}
