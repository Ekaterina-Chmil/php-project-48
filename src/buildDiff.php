<?php

declare(strict_types=1);

namespace Differ;

function buildDiff(array $data1, array $data2): array
{
    $keys = array_keys($data1 + $data2);
    sort($keys);
    $diff = [];

    foreach ($keys as $key) {
        $has1 = array_key_exists($key, $data1);
        $has2 = array_key_exists($key, $data2);

        $val1 = $has1 ? $data1[$key] : null;
        $val2 = $has2 ? $data2[$key] : null;

        if ($has1 && !$has2) {
            $diff[] = ['key' => $key, 'status' => 'removed', 'value' => $val1];
        } elseif (!$has1 && $has2) {
            $diff[] = ['key' => $key, 'status' => 'added', 'value' => $val2];
        } elseif (is_array($val1) && is_array($val2)) {
            $diff[] = ['key' => $key, 'status' => 'nested', 'children' => buildDiff($val1, $val2)];
        } elseif ($val1 !== $val2) {
            $diff[] = ['key' => $key, 'status' => 'changed', 'oldValue' => $val1, 'newValue' => $val2];
        } else {
            $diff[] = ['key' => $key, 'status' => 'unchanged', 'value' => $val1];
        }
    }

    return $diff;
}
