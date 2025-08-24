<?php

namespace Differ;

function genDiff(string $filepath1, string $filepath2, string $format = 'stylish'): array
{
    $fullPath1 = realpath($filepath1);
    $fullPath2 = realpath($filepath2);

    if ($fullPath1 === false || $fullPath2 === false) {
        throw new \Exception("Файл не найден!");
    }

    $data1 = json_decode(file_get_contents($fullPath1), true);
    $data2 = json_decode(file_get_contents($fullPath2), true);

    return [$data1, $data2];
}
