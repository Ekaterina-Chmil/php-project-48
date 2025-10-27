<?php

declare(strict_types=1);

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;
use RuntimeException;

const FORMAT_JSON = 'json';
const FORMAT_YML = 'yml';
const FORMAT_YAML = 'yaml';

function parse(string $dataFormat, string $data): array
{
    return match ($dataFormat) {
        FORMAT_JSON => jsonParse($data),
        FORMAT_YML, FORMAT_YAML => yamlParse($data),
        default => throw new RuntimeException(sprintf('Unknown format: %s!', $dataFormat)),
    };
}

function jsonParse(string $data): array
{
    $parsed = json_decode($data, true);
    if ($parsed === null && json_last_error() !== JSON_ERROR_NONE) {
        throw new RuntimeException('Invalid JSON data!');
    }
    return $parsed;
}

function yamlParse(string $data): array
{
    $parsed = Yaml::parse($data);
    if (!is_array($parsed)) {
        throw new RuntimeException('Invalid YAML data!');
    }
    return $parsed;
}
