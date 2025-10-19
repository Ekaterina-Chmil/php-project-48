<?php

namespace Differ\Formatters;

use function Differ\Formatters\stylish;
use function Differ\Formatters\plain;

function format(array $diff, string $formatName): string
{
    return match ($formatName) {
        'stylish' => stylish($diff),
        'plain'   => plain($diff),
        default   => throw new \Exception("Unknown format: {$formatName}"),
    };
}
