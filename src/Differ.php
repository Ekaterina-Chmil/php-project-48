<?php

declare(strict_types=1);

namespace Differ\Differ;

use function Differ\DataGetter\getFileData;
use function Differ\Parser\parse;
use function Differ\Formatter\format;

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

    return format($formatName, $diff);
}

function buildDiffData(array $data1, array $data2): array
{
    $keys = array_keys($data1 + $data2);
    sort($keys);

    $result = [];
    foreach ($keys as $key) {
        $has1 = array_key_exists($key, $data1);
        $has2 = array_key_exists($key, $data2);

        $val1 = $has1 ? $data1[$key] : null;
        $val2 = $has2 ? $data2[$key] : null;

        if ($has1 && !$has2) {
            $result[] = ['key' => $key, 'status' => REMOVED, 'value' => $val1];
        } elseif (!$has1 && $has2) {
            $result[] = ['key' => $key, 'status' => ADDED, 'value' => $val2];
        } elseif (is_array($val1) && is_array($val2)) {
            $children = buildDiffData($val1, $val2);
            $result[] = ['key' => $key, 'status' => NESTED, 'children' => $children];
        } elseif ($val1 !== $val2) {
            $result[] = ['key' => $key, 'status' => CHANGED, 'oldValue' => $val1, 'newValue' => $val2];
        } else {
            $result[] = ['key' => $key, 'status' => UNCHANGED, 'value' => $val1];
        }
    }

    return $result;
}
