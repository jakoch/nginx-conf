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
        $conf   = __DIR__ . '/fixtures/nginx.conf';
        $parser = new Parser($conf);
        $object = $parser->parse();

        $this->assertObjectHasAttribute('name', $object);
        $this->assertSame('[root]', $object->name);
    }

    public function testParser_Nginx2Conf()
    {
        $conf   = __DIR__ . '/fixtures/nginx-2.conf';
        $parser = new Parser($conf);
        $object = $parser->parse();

        $this->assertObjectHasAttribute('name', $object);
        $this->assertSame('[root]', $object->name);
    }

    public function testParser_NginxKibanaConf()
    {
        $conf   = __DIR__ . '/fixtures/nginx-kibana.conf';
        $parser = new Parser($conf);
        $object = $parser->parse();

        $this->assertSame(count($object->children), 1); # root has 1 child: server
        $this->assertSame($object->children[0]->name, 'server');

        $this->assertSame(count($object->children[0]->children), 11); # the "server node" has 11 child nodes

        $this->assertSame($object->children[0]->children[2]->name,'access_log');
        $this->assertSame($object->children[0]->children[2]->value, '/var/log/nginx/kibana.myhost.org.access.log');

        $this->assertSame($object->children[0]->children[9]->children[0]->name, 'proxy_pass');
        $this->assertSame($object->children[0]->children[9]->children[0]->value, 'http://127.0.0.1:9200');
    }

    public function testParser_NginxSSL()
    {
        $conf   = __DIR__ . '/fixtures/nginx-ssl.conf';
        $parser = new Parser($conf);
        $object = $parser->parse();

        $this->assertObjectHasAttribute('name', $object);
        $this->assertSame('[root]', $object->name);

    }

    public function testParser_Regex()
    {
        $conf   = __DIR__ . '/fixtures/regex.conf';
        $parser = new Parser($conf);
        $object = $parser->parse();

        $this->assertSame('"([\w+])" $1 last', $object->children[0]->children[0]->value);
    }

}
