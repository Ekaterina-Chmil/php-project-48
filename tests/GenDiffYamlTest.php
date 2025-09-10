<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use function Differ\genDiff;

class GenDiffYamlTest extends TestCase
{
    public function testFlatYamlFiles()
    {
        $file1 = __DIR__ . '/fixtures/file1.yml';
        $file2 = __DIR__ . '/fixtures/file2.yml';

        $expected = <<<EOT
{
  - follow: false
    host: hexlet.io
  - proxy: 123.234.53.22
  - timeout: 50
  + timeout: 20
  + verbose: true
}
EOT;

        $this->assertEquals($expected, genDiff($file1, $file2));
    }
}

