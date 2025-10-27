<?php

declare(strict_types=1);

namespace Differ\Formatters\Stylish;

function format(array $data): string
{
    $iter = function (array $data, int $depth = 1) use (&$iter): string {
        $indentSize = 4;
        $currentIndent = str_repeat(' ', $depth * $indentSize - 2);
        $bracketIndent = str_repeat(' ', ($depth - 1) * $indentSize);

        $stringify = function ($value, int $depth) use (&$stringify): string {
            if (!is_array($value)) {
                return formatPrimitive($value);
            }

            $indentSize = 4;
            $currentIndent = str_repeat(' ', ($depth + 1) * $indentSize);
            $bracketIndent = str_repeat(' ', $depth * $indentSize);

            $lines = [];
            foreach ($value as $k => $v) {
                $lines[] = "{$currentIndent}{$k}: " . (is_array($v) ? $stringify($v, $depth + 1) : formatPrimitive($v));
            }
            return "{\n" . implode("\n", $lines) . "\n{$bracketIndent}}";
        };

        $lines = array_map(function ($item) use ($iter, $currentIndent, $depth, $stringify) {
            $key = $item['key'];
            $status = $item['status'];

            switch ($status) {
                case 'added':
                    return "{$currentIndent}+ {$key}: " . $stringify($item['value'], $depth);
                case 'removed':
                    return "{$currentIndent}- {$key}: " . $stringify($item['value'], $depth);
                case 'unchanged':
                    return "{$currentIndent}  {$key}: " . $stringify($item['value'], $depth);
                case 'changed':
                    $old = "{$currentIndent}- {$key}: " . $stringify($item['oldValue'], $depth);
                    $new = "{$currentIndent}+ {$key}: " . $stringify($item['newValue'], $depth);
                    return $old . "\n" . $new;
                case 'nested':
                    return "{$currentIndent}  {$key}: {\n" .
                        $iter($item['children'], $depth + 1) .
                        "\n" . $currentIndent . "  }";
                default:
                    throw new \Exception("Unknown status: {$status}");
            }
        }, $data);

        return implode("\n", $lines);
    };

    return "{\n" . $iter($data) . "\n}";
}

function formatPrimitive(mixed $value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if ($value === null) {
        return 'null';
    }
    return (string) $value;
}
