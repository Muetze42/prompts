<?php

namespace NormanHuth\Prompts;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Laravel\Prompts\Concerns\Colors;

/**
 * @mixin \Laravel\Prompts\Concerns\Colors
 */
class Support
{
    use Colors;

    public static function subtitled(array|Collection $options): array
    {
        if ($options instanceof Collection) {
            $options = $options->toArray();
        }
        return Arr::map($options, function (string $value, string|int $key) {
            if (is_int($key)) {
                return $value;
            }

            return (new static())->reset($key) . "\n    " . (new static())->dim($value);
        });
    }
}
