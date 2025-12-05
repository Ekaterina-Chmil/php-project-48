<?php

declare(strict_types=1);

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;
use JsonException;

const FORMAT_STYLISH = 'stylish';
const FORMAT_PLAIN = 'plain';
const FORMAT_JSON = 'json';

function parse(string $dataFormat, string $data): array
{
    return match ($dataFormat) {
        'json' => json_decode($data, true, 512, JSON_THROW_ON_ERROR),
        'yaml', 'yml' => Yaml::parse($data),
        default => throw new \Exception("Unknown format: {$dataFormat}"),
    };
}
