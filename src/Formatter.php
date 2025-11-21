<?php

declare(strict_types=1);

namespace Differ\Formatter;

use const Differ\FORMAT_STYLISH;
use const Differ\FORMAT_PLAIN;
use const Differ\FORMAT_JSON;
use function Differ\Formatters\Stylish\render as stylishFormat;
use function Differ\Formatters\Plain\render as plainFormat;
use function Differ\Formatters\Json\render as jsonFormat;

function render(string $renderType, array $data): string
{
    return match ($renderType) {
        FORMAT_STYLISH => stylishFormat($data),
        FORMAT_PLAIN   => plainFormat($data),
        FORMAT_JSON    => jsonFormat($data),
        default        => throw new \Exception("Unknown format: {$renderType}"),
    };
}
