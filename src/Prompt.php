<?php

namespace NormanHuth\Prompts;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\select;

class Prompt extends AbstractPrompt
{
    /**
     * Prompt the user to select an option. Options always numeric for Windows.
     */
    public static function select(
        string $label,
        array|Collection $options,
        int|string|null $default = null,
        int $scroll = 5,
        mixed $validate = null,
        string $hint = '',
        bool|string $required = true
    ): int|string {
        if (windows_os()) {
            if ($options instanceof Collection) {
                $options = $options->toArray();
            }

            $optionsKeys = $options;
            if (!is_int(array_key_first($options))) {
                $optionsKeys = array_keys($optionsKeys);
            }

            $options = array_values($options);

            if ($default) {
                $default = Arr::where(
                    $optionsKeys,
                    fn (int|string $value, int $key) => $value === $default
                );
                $default = array_key_first($default);
            }

            $result = select($label, $options, $default, $scroll, $validate, $hint, $required);

            $result = array_keys(Arr::where($options, fn (string $value) => $value === $result));

            return array_values(Arr::where($optionsKeys, fn (string $value, int $key) => in_array($key, $result)))[0];
        }

        return select(...func_get_args());
    }

    /**
     * Prompt the user to select multiple options. Options always numeric for Windows.
     */
    public static function multiselect(
        string $label,
        array|Collection $options,
        array|Collection $default = [],
        int $scroll = 5,
        bool|string $required = false,
        mixed $validate = null,
        string $hint = 'Use the space bar to select options.'
    ): array {
        if (windows_os()) {
            if ($options instanceof Collection) {
                $options = $options->toArray();
            }
            if ($default instanceof Collection) {
                $default = $default->toArray();
            }

            $optionsKeys = $options;
            if (!is_int(array_key_first($options))) {
                $optionsKeys = array_keys($optionsKeys);
            }

            $options = array_values($options);

            if (count($default)) {
                $default = Arr::where(
                    $optionsKeys,
                    fn (int|string $value, int $key) => in_array($value, $default)
                );
                $default = array_keys($default);
            }

            $result = multiselect($label, $options, $default, $scroll, $required, $validate, $hint);

            $result = array_keys(Arr::where($options, fn (string $value) => in_array($value, $result)));

            return array_values(Arr::where($optionsKeys, fn (string $value, int $key) => in_array($key, $result)));
        }

        return multiselect(...func_get_args());
    }

    public static function select2(
        string $label,
        array|Collection $options,
        int|string|null $default = null,
        int $scroll = 5,
        mixed $validate = null,
        string $hint = '',
        bool|string $required = true
    ): int|string {
        return static::select($label, Support::subtitled($options), $default, $scroll, $validate, $hint, $required);
    }

    public static function multiselect2(
        string $label,
        array|Collection $options,
        array|Collection $default = [],
        int $scroll = 5,
        bool|string $required = false,
        mixed $validate = null,
        string $hint = 'Use the space bar to select options.'
    ): array {
        return static::multiselect(
            $label,
            Support::subtitled($options),
            $default,
            $scroll,
            $required,
            $validate,
            $hint
        );
    }
}
