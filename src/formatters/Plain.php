<?php

namespace Differ\Formatters;

function formatValue(mixed $value): string
{
    if (is_array($value)) {
        return '[complex value]';
    }
    if ($value === null) {
        return 'null';
    }
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_string($value)) {
        return "'$value'";
    }
    return (string)$value;
}

function plain(array $diff, string $parent = ''): string
{
    $lines = array_map(function ($item) use ($parent) {
        $key = $parent === '' ? $item['key'] : $parent . '.' . $item['key'];

        switch ($item['status']) {
            case 'added':
                $value = formatValue($item['value']);
                return "Property '$key' was added with value: $value";
            case 'removed':
                return "Property '$key' was removed";
            case 'updated':
            case 'changed':
                $old = formatValue($item['oldValue']);
                $new = formatValue($item['newValue']);
                return "Property '$key' was updated. From $old to $new";
            case 'nested':
                return plain($item['children'], $key);
            case 'unchanged':
                return null;
            default:
                throw new \Exception("Unknown status: {$item['status']}");
        }
    }, $diff);

    return implode("\n", array_filter($lines));
}
