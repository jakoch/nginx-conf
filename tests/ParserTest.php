<?php

namespace NginxConfTests;

use NginxConf\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParser1()
    {
        $conf = __DIR__ . '/fixtures/global-directive.conf';
        $parser = new Parser($conf);
        $array = $parser->parse();

        $expected_array = array(
            'type' => 'param',
            'name' => 'worker_processes',
            'value' => 1
        );

        $this->assertSame($expected_array, $array);
    }

    public function testParser2()
    {
        $conf = __DIR__ . '/fixtures/block-with-directive.conf';
        $parser = new Parser($conf);
        $array = $parser->parse();

        $expected_array = array(
            'type' => 'param',
            'name' => 'worker_processes',
            'value' => 1
        );

        $this->assertSame($expected_array, $array);
    }

    public function testParser3()
    {
        $conf = __DIR__ . '/fixtures/nginx.conf';
        $parser = new Parser($conf);
        $array = $parser->parse();

        $expected_array = array(
            'type' => 'param',
            'name' => 'worker_processes',
            'value' => 1
        );

        $this->assertSame($expected_array, $array);
    }
}
