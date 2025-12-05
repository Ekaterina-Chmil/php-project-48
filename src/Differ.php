<?php

declare(strict_types=1);

namespace Differ\Differ;

use Illuminate\Support\Collection;

use function Differ\Parsers\parse;
use function Differ\Formatter\render;

const UNCHANGED = 'unchanged';
const ADDED = 'added';
const REMOVED = 'removed';
const NESTED = 'nested';
const CHANGED = 'changed';

function genDiff(string $filepath1, string $filepath2, string $formatName = 'stylish'): string
{
    $data1 = getFileData($filepath1);
    $data2 = getFileData($filepath2);

    $parsed1 = parse($data1['dataFormat'], $data1['rawData']);
    $parsed2 = parse($data2['dataFormat'], $data2['rawData']);

    $diff = buildDiffData($parsed1, $parsed2);

    return render($formatName, $diff);
}

function buildDiffItem(string $key, bool $has1, bool $has2, mixed $val1, mixed $val2): array
{
    if ($has1 && !$has2) {
        return [
            'key' => $key,
            'status' => REMOVED,
            'value' => $val1,
        ];
    }
    if (!$has1 && $has2) {
        return [
            'key' => $key,
            'status' => ADDED,
            'value' => $val2,
        ];
    }
    if (is_array($val1) && is_array($val2)) {
        $children = buildDiffData($val1, $val2);
        return [
            'key' => $key,
            'status' => NESTED,
            'children' => $children,
        ];
    }
    if ($val1 !== $val2) {
        return [
            'key' => $key,
            'status' => CHANGED,
            'oldValue' => $val1,
            'newValue' => $val2,
        ];
    }
    return [
        'key' => $key,
        'status' => UNCHANGED,
        'value' => $val1,
    ];
}

function buildDiffData(array $data1, array $data2): array
{
    $keys = array_keys($data1 + $data2);
    $sortedKeys = Collection::make($keys)->sort()->values()->all();

    return array_map(function ($key) use ($data1, $data2) {
        $has1 = array_key_exists($key, $data1);
        $has2 = array_key_exists($key, $data2);

        $val1 = $has1 ? $data1[$key] : null;
        $val2 = $has2 ? $data2[$key] : null;

        return buildDiffItem($key, $has1, $has2, $val1, $val2);
    }, $sortedKeys);
}

function getFileData(string $filePath): array
{
    if (!file_exists($filePath)) {
        throw new \RuntimeException(sprintf('File on path "%s" not found!', $filePath));
    }

    return [
        'dataFormat' => getFileFormat($filePath),
        'rawData' => file_get_contents($filePath),
    ];
}

function getFileFormat(string $filePath): string
{
    return pathinfo($filePath, PATHINFO_EXTENSION);
}
