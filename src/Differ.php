<?php

declare(strict_types=1);

namespace Differ;

use Funct\Collection;
use Symfony\Component\Yaml\Yaml;

use function Differ\Parsers\parse;
use function Differ\buildDiff;
use function Differ\format;

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

    $diff = buildDiff($data1, $data2);

    return format($format, $diff);
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
