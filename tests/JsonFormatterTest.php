<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Formatters\Json\format;

class JsonFormatterTest extends TestCase
{
    public function testJsonFormat(): void
    {
        $diff = [
            ['key' => 'host', 'status' => 'unchanged', 'value' => 'hexlet.io'],
            ['key' => 'timeout', 'status' => 'changed', 'oldValue' => 50, 'newValue' => 20],
        ];

        $expected = json_encode($diff, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT) . PHP_EOL;

        $this->assertEquals($expected, format($diff));
    }
}
