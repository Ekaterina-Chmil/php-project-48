<?php

namespace Differ;

use Funct\Collection;

function genDiff(string $filepath1, string $filepath2, string $format = 'stylish'): string
{
    $fullPath1 = realpath($filepath1);
    $fullPath2 = realpath($filepath2);

    if ($fullPath1 === false || $fullPath2 === false) {
        throw new \Exception("Файл не найден!");
    }

    $data1 = json_decode(file_get_contents($fullPath1), true);
    $data2 = json_decode(file_get_contents($fullPath2), true);

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
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    return (string) $value;
}
