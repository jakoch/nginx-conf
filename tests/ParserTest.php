<?php

namespace NginxConfTests;

use NginxConf\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{

    public function testParser_GlobalDirective()
    {
        $conf   = __DIR__ . '/fixtures/global-directive.conf';
        $parser = new Parser($conf);
        $object = $parser->parse();

        $this->assertObjectHasAttribute('name', $object);
        $this->assertSame('[root]', $object->name);

        $this->assertSame(count($object->children), 5);

        $this->assertSame($object->children[0]->name, 'directive_underscore');
        $this->assertSame($object->children[0]->value, '1');
    }

    public function testParser_BlockWithDirectiveConf()
    {
        $conf   = __DIR__ . '/fixtures/block-with-directive.conf';
        $parser = new Parser($conf);
        $object = $parser->parse();

        $this->assertObjectHasAttribute('name', $object);
        $this->assertSame('[root]', $object->name);

        $this->assertSame(count($object->children), 1);

        $this->assertSame($object->children[0]->name, 'events');
        $this->assertSame($object->children[0]->value, '');
        $this->assertSame(count($object->children[0]->children), 1);

        $this->assertSame($object->children[0]->children[0]->name, 'worker_connections');
        $this->assertSame($object->children[0]->children[0]->value, '1024');
    }

    public function testParser_NginxConf()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );

        $conf   = __DIR__ . '/fixtures/nginx.conf';
        $parser = new Parser($conf);
        $array  = $parser->parse();

        $expected_array = array(
            'type'  => 'param',
            'name'  => 'worker_processes',
            'value' => 1
        );

        $this->assertSame($expected_array, $array);
    }

    public function testParser_Nginx2Conf()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );

        $conf   = __DIR__ . '/fixtures/nginx-2.conf';
        $parser = new Parser($conf);
        $array  = $parser->parse();

        $expected_array = array(
            'type'  => 'param',
            'name'  => 'worker_processes',
            'value' => 1
        );

        $this->assertSame($expected_array, $array);
    }

    public function testParser_NginxKibanaConf()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );

        $conf   = __DIR__ . '/fixtures/nginx-kibana.conf';
        $parser = new Parser($conf);
        $array  = $parser->parse();
    }

}
