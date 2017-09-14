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
        $listener->setInsertSize(3);
        $listener->setInsertIgnore(true);
        $largeXmlReader->setFilePath($file);
        $largeXmlReader->setListener($listener);
        $largeXmlReader->parse();
        $data = $listener->getData();
        $this->assertEquals(md5($data), 'ea861be1f7236ce763072870383d64ab');
    }
}