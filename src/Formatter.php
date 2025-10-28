<?php

declare(strict_types=1);

namespace Differ\Formatter;

use function Differ\Formatters\Stylish\format as stylishFormat;
use function Differ\Formatters\Plain\format as plainFormat;
use function Differ\Formatters\Json\format as jsonFormat;

const FORMAT_STYLISH = 'stylish';
const FORMAT_PLAIN = 'plain';
const FORMAT_JSON = 'json';

function format(string $formatName, array $data): string
{
    return match ($formatName) {
        FORMAT_STYLISH => stylishFormat($data),
        FORMAT_PLAIN   => plainFormat($data),
        FORMAT_JSON    => jsonFormat($data),
        default        => throw new \Exception("Unknown format: {$formatName}"),
    };
}
