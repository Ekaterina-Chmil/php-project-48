<?php

declare(strict_types=1);

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;
use JsonException;

const FORMAT_STYLISH = 'stylish';
const FORMAT_PLAIN = 'plain';
const FORMAT_JSON = 'json';

const SUPPORTED_FORMATS = [
    'json',
    'yaml',
    'yml',
];

function parse(string $dataFormat, string $data): array
{
    if (!in_array($dataFormat, SUPPORTED_FORMATS, true)) {
        throw new \Exception("Unknown format: {$dataFormat}");
    }

    return match ($dataFormat) {
        'json' => jsonParse($data),
        'yaml', 'yml' => yamlParse($data),
    };
}

function jsonParse(string $data): array
{
    return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
}

function yamlParse(string $data): array
{
    return Yaml::parse($data);
}
