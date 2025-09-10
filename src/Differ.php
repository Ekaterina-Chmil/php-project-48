<?php

namespace Differ;

use Funct\Collection;
use Symfony\Component\Yaml\Yaml;

use function Differ\Parsers\parse;

function genDiff(string $filepath1, string $filepath2, string $format = 'stylish'): string
{
    $fullPath1 = realpath($filepath1);
    $fullPath2 = realpath($filepath2);

    if ($fullPath1 === false || $fullPath2 === false) {
        throw new \Exception("Файл не найден!");
    }

    $fileContent1 = file_get_contents($filepath1);
    $fileContent2 = file_get_contents($filepath2);

    $format1 = getFormat($fullPath1);
    $format2 = getFormat($fullPath2);

    $data1 = parse($format1, $fileContent1);
    $data2 = parse($format2, $fileContent2);

    $allKeys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    $sortedKeys = Collection\sortBy($allKeys, fn($key) => $key);

    $lines = array_map(function ($key) use ($data1, $data2) {
        $has1 = array_key_exists($key, $data1);
        $has2 = array_key_exists($key, $data2);

        if ($has1 && $has2) {
            if ($data1[$key] === $data2[$key]) {
                return "    {$key}: " . formatValue($data1[$key]);
            }
            return "  - {$key}: " . formatValue($data1[$key]) . "\n  + {$key}: " . formatValue($data2[$key]);
        }
        if ($has1) {
            return "  - {$key}: " . formatValue($data1[$key]);
        }
        return "  + {$key}: " . formatValue($data2[$key]);
    }, $sortedKeys);

    return "{\n" . implode("\n", $lines) . "\n}";
}

function formatValue($value): string
{
    if (is_array($value)) {
        return 'Array';
    }

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if ($value === null) {
        return 'null';
    }

    return (string) $value;
}

function getFormat(string $filepath): string
{
    $ext = pathinfo($filepath, PATHINFO_EXTENSION);

    return match (strtolower($ext)) {
        'json' => 'json',
        'yml' => 'yml',
        'yaml' => 'yaml',
        default => throw new \RuntimeException("Unknown file format: $ext"),
    };
}
