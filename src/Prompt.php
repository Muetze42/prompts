<?php

namespace NormanHuth\Prompts;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\multisearch;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\password;
use function Laravel\Prompts\pause;
use function Laravel\Prompts\search;
use function Laravel\Prompts\select;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\text;

class Prompt
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

    public static function text(
        string $label,
        string $placeholder = '',
        string $default = '',
        bool|string $required = false,
        mixed $validate = null,
        string $hint = ''
    ): string {
        return text(...func_get_args());
    }

    public static function password(
        string $label,
        string $placeholder = '',
        bool|string $required = false,
        mixed $validate = null,
        string $hint = ''
    ): string {
        return password(...func_get_args());
    }

    public static function confirm(
        string $label,
        bool $default = true,
        string $yes = 'Yes',
        string $no = 'No',
        bool|string $required = false,
        mixed $validate = null,
        string $hint = ''
    ): string {
        return confirm(...func_get_args());
    }

    public static function suggest(
        string $label,
        array|Collection|Closure $options,
        string $placeholder = '',
        string $default = '',
        int $scroll = 5,
        bool|string $required = false,
        mixed $validate = null,
        string $hint = ''
    ): string {
        return suggest(...func_get_args());
    }

    public static function search(
        string $label,
        Closure $options,
        string $placeholder = '',
        int $scroll = 5,
        mixed $validate = null,
        string $hint = '',
        bool|string $required = true
    ): int|string {
        return search(...func_get_args());
    }

    public static function multisearch(
        string $label,
        Closure $options,
        string $placeholder = '',
        int $scroll = 5,
        bool|string $required = false,
        mixed $validate = null,
        string $hint = 'Use the space bar to select options.'
    ): array {
        return multisearch(...func_get_args());
    }

    public static function pause(string $message = 'Press enter to continue...'): bool
    {
        return pause(...func_get_args());
    }
}
