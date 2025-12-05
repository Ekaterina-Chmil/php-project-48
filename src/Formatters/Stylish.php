<?php

declare(strict_types=1);

namespace Differ\Formatters\Stylish;

use const Differ\Differ\ADDED;
use const Differ\Differ\REMOVED;
use const Differ\Differ\UNCHANGED;
use const Differ\Differ\CHANGED;
use const Differ\Differ\NESTED;

const INDENT_SYMBOL = ' ';
const INDENT_COUNT = 4;
const COMPARE_SYMBOL_LENGTH = 2;

function render(array $data): string
{
    return stringify($data, 1);
}

function stringify(array $data, int $depth = 1): string
{
    $indentSize = $depth * INDENT_COUNT - COMPARE_SYMBOL_LENGTH;
    $indentValue = str_repeat(INDENT_SYMBOL, $indentSize);

    $lines = array_map(function ($item) use ($depth, $indentValue) {
        $key = $item['key'];
        $status = $item['status'];

        switch ($status) {
            case ADDED:
                $value = formatValue($item['value'], $depth + 1);
                return "{$indentValue}+ {$key}: {$value}";

            case REMOVED:
                $value = formatValue($item['value'], $depth + 1);
                return "{$indentValue}- {$key}: {$value}";

            case UNCHANGED:
                $value = formatValue($item['value'], $depth + 1);
                return "{$indentValue}  {$key}: {$value}";

            case CHANGED:
                $oldVal = formatValue($item['oldValue'], $depth + 1);
                $newVal = formatValue($item['newValue'], $depth + 1);
                $old = "{$indentValue}- {$key}: {$oldVal}";
                $new = "{$indentValue}+ {$key}: {$newVal}";
                return "{$old}\n{$new}";

            case NESTED:
                $nestedStr = stringify($item['children'], $depth + 1);
                return "{$indentValue}  {$key}: {$nestedStr}";
            default:
                throw new \Exception("Unknown status: {$status}");
        }
    }, $data);

    $innerIndent = str_repeat(INDENT_SYMBOL, ($depth - 1) * INDENT_COUNT);
    $joinedLines = implode("\n", $lines);
    return "{\n{$joinedLines}\n{$innerIndent}}";
}

function formatValue(mixed $value, int $depth): string
{
    if (is_array($value) && !array_is_list($value)) {
        return stringifyValue($value, $depth);
    }
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if ($value === null) {
        return 'null';
    }
    return (string) $value;
}

function stringifyValue(array $value, int $depth): string
{
    $indentSize = $depth * INDENT_COUNT;
    $indentValue = str_repeat(INDENT_SYMBOL, $indentSize);

    $lines = array_map(function ($key, $val) use ($indentValue, $depth) {
        $isComplexArray = is_array($val) && !array_is_list($val);
        $formattedValue = $isComplexArray ? stringifyValue($val, $depth + 1) : formatValue($val, $depth);
        return "{$indentValue}{$key}: {$formattedValue}";
    }, array_keys($value), array_values($value));

    $innerIndent = str_repeat(INDENT_SYMBOL, ($depth - 1) * INDENT_COUNT);
    $joinedLines = implode("\n", $lines);
    return "{\n{$joinedLines}\n{$innerIndent}}";
}
