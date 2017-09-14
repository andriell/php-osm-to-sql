<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 11:20
 */

namespace osm2sql;


use osm2sql\mysql\FileReaderListener;
use osm2sql\mysql\StrReaderListener;

class LargeXmlReaderTest extends \PHPUnit_Framework_TestCase
{
    public function test1()
    {
        $file = __DIR__ . '/../../resources/test.osm';
        $largeXmlReader = new LargeXmlReader();
        $listener = new StrReaderListener();
        $largeXmlReader->setFilePath($file);
        $largeXmlReader->setListener($listener);
        $largeXmlReader->parse();
        $data = $listener->getData();
        $this->assertEquals(md5($data), '46501958201eb696f58c07c0671cd533');
    }
}