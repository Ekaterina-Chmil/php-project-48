<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $filepath): array
{
    $ext = pathinfo($filepath, PATHINFO_EXTENSION);

    $content = file_get_contents($filepath);

    if ($ext === 'json') {
        return json_decode($content, true);
    }

    if (in_array($ext, ['yml', 'yaml'])) {
        return json_decode(json_encode(Yaml::parse($content, Yaml::PARSE_OBJECT_FOR_MAP)), true);
    }

    throw new \Exception("Неподдерживаемый формат файла: {$ext}");
}




