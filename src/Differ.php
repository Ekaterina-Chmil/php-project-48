<?php

namespace Differ;

function genDiff(string $filepath1, string $filepath2, string $format = 'stylish'): array
{
    $content1 = file_get_contents($filepath1);
    $data1 = json_decode($content1, true);

    $content2 = file_get_contents($filepath2);
    $data2 = json_decode($content2, true);

    return [$data1, $data2];
}

