<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

use function Differ\Differ\genDiff;

class GenDiffTest extends TestCase
{
    #[DataProvider('diffDataProvider')]
    public function testGenDiff(string $file1, string $file2, string $format, string $expectedFile): void
    {
        $result = genDiff($file1, $file2, $format);
        $this->assertStringEqualsFile($expectedFile, $result);
    }

    public static function diffDataProvider(): array
    {
        $f = fn($name) => __DIR__ . '/fixtures/' . $name;
        return [
            [$f('flat1.json'), $f('flat2.json'), 'stylish', $f('expected_flat_stylish.txt')],
            [$f('flat1.yml'),  $f('flat2.yml'),  'stylish', $f('expected_flat_stylish.txt')],
            [$f('flat1.json'), $f('flat2.json'), 'plain',   $f('expected_flat_plain.txt')],
            [$f('flat1.yml'),  $f('flat2.yml'),  'plain',   $f('expected_flat_plain.txt')],

            [$f('nested1.json'), $f('nested2.json'), 'stylish', $f('expected_nested_stylish.txt')],
            [$f('nested1.yml'),  $f('nested2.yml'), 'stylish', $f('expected_nested_stylish.txt')],
            [$f('nested1.json'), $f('nested2.json'), 'plain',   $f('expected_nested_plain.txt')],
            [$f('nested1.yml'),  $f('nested2.yml'), 'plain',   $f('expected_nested_plain.txt')],
        ];
    }
}
