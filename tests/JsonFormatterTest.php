<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Formatters\Json\json;

class JsonFormatterTest extends TestCase
{
    public function testJsonFormat(): void
    {
        $diff = [
            ['key' => 'host', 'status' => 'unchanged', 'value' => 'hexlet.io'],
            ['key' => 'timeout', 'status' => 'changed', 'oldValue' => 50, 'newValue' => 20],
        ];

        $expected = json_encode($diff, JSON_PRETTY_PRINT);

        $this->assertEquals($expected, json($diff));
    }
}
