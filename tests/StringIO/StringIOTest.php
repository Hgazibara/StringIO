<?php

namespace StringIO;

class StringIOTest extends \PHPUnit_Framework_TestCase {
    
    public static function setUpBeforeClass() {
        parent::setUpBeforeClass();
        StringIO::register();
    }
    
    public static function tearDownAfterClass() {
        parent::tearDownAfterClass();
        if (\in_array(StringIO::PROTOCOL, \stream_get_wrappers())) {
            \stream_wrapper_unregister(StringIO::PROTOCOL);
        }
    }
    
    public function testTell() {
        $handler = \fopen('stringio://test', 'w');
        \fwrite($handler, 'test');
        $this->assertSame(4, \ftell($handler));
        \fclose($handler);
    }
    
    public function testSeek() {
        $handler = \fopen('stringio://test', 'w');
        \fwrite($handler, 'abcdefghijk');
        
        \fseek($handler, 1, \SEEK_SET);
        $this->assertSame(1, \ftell($handler));
        
        \fseek($handler, 4, \SEEK_CUR);
        $this->assertSame(5, \ftell($handler));
        
        \fseek($handler, -4, \SEEK_END);
        $this->assertSame(7, \ftell($handler));
        
        \fseek($handler, 4, \SEEK_END);
        $this->assertSame(15, \ftell($handler));
        
        \fclose($handler);
    }
    
    public function testRead() {
        $handler = \fopen('stringio://test', 'w+');
        \fwrite($handler, 'abcdefghijk');
        
        \fseek($handler, 4, \SEEK_SET);
        $this->assertSame('efghijk', \fread($handler, 100));
        
        \fclose($handler);
    }
}
