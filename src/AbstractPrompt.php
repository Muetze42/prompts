<?php

namespace NormanHuth\Prompts;

use Closure;
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

abstract class AbstractPrompt
{
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

    public static function multiselect(
        string $label,
        array|Collection $options,
        array|Collection $default = [],
        int $scroll = 5,
        bool|string $required = false,
        mixed $validate = null,
        string $hint = 'Use the space bar to select options.'
    ): array {
        return multiselect(...func_get_args());
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

    public static function pause(string $message = 'Press enter to continue...'): bool
    {
        return pause(...func_get_args());
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

    public static function select(
        string $label,
        array|Collection $options,
        int|string|null $default = null,
        int $scroll = 5,
        mixed $validate = null,
        string $hint = '',
        bool|string $required = true
    ): int|string {
        return select(...func_get_args());
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
}
