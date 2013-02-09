<?php

require_once 'lib/PicoFeed/Parser.php';

use PicoFeed\Atom;

class AtomParserTest extends PHPUnit_Framework_TestCase
{
    public function testFormatOk()
    {
        $parser = new Atom(file_get_contents('tests/fixtures/atomsample.xml'));
        $r = $parser->execute();

        $this->assertEquals('Example Feed', $r->title);
        $this->assertEquals('http://example.org/', $r->url);
        $this->assertEquals('urn:uuid:60a76c80-d399-11d9-b93C-0003939e0af6', $r->id);
        $this->assertEquals('1071340202', $r->updated);
        $this->assertEquals(1, count($r->items));

        $this->assertEquals('Atom-Powered Robots Run Amok', $r->items[0]->title);
        $this->assertEquals('http://example.org/2003/12/13/atom03', $r->items[0]->url);
        $this->assertEquals('urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a', $r->items[0]->id);
        $this->assertEquals('1071340202', $r->items[0]->updated);
        $this->assertEquals('John Doe', $r->items[0]->author);
        $this->assertEquals('Some text.', $r->items[0]->content);


        $parser = new Atom(file_get_contents('tests/fixtures/atom.xml'));
        $r = $parser->execute();

        $this->assertEquals('The Official Google Blog', $r->title);
        $this->assertEquals('http://googleblog.blogspot.com/', $r->url);
        $this->assertEquals('tag:blogger.com,1999:blog-10861780', $r->id);
        $this->assertEquals('1360177133', $r->updated);
        $this->assertEquals(25, count($r->items));

        $this->assertEquals('A Chrome Experiment made with some friends from Oz', $r->items[0]->title);
        $this->assertEquals('http://feedproxy.google.com/~r/blogspot/MKuf/~3/S_hccisqTW8/a-chrome-experiment-made-with-some.html', $r->items[0]->url);
        $this->assertEquals('tag:blogger.com,1999:blog-10861780.post-4204073939915223997', $r->items[0]->id);
        $this->assertEquals('1360083741', $r->items[0]->updated);
        $this->assertEquals('Emily Wood', $r->items[0]->author);
        $this->assertEquals(3227, strlen($r->items[0]->content));
    }


    public function testBadInput()
    {
        $parser = new Atom('ffhhghg');
        $r = $parser->execute();

        $this->assertEquals('', $r->title);
    }
}