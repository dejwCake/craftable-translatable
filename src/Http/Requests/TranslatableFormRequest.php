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
     * The rule of a locale that is not required: `required` becomes `nullable`.
     *
     * @param array<int|string, object|string>|string $rule
     * @return array<int|string, object|string>|string
     */
    private static function optionalRule(array|string $rule): array|string
    {
        // TODO add support for rules defined via custom Rule classes
        if (is_string($rule)) {
            return str_replace('required', 'nullable', $rule);
        }

        $key = array_search('required', $rule, true);
        if ($key !== false) {
            unset($rule[$key]);
            $rule[] = 'nullable';
        }

        return $rule;
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
            $rule = $locale['required'] ? $rule : self::optionalRule($rule);

            return [
                sprintf('%s.%s', $ruleKey, $locale['locale']) => is_array($rule) ? array_values($rule) : $rule,
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
