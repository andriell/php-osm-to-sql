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
        ini_set('memory_limit', '10M');

        $fileOsm = __DIR__ . '/../../resources/test.osm';
        $fileSql = __DIR__ . '/../../resources/test.sql';
        $largeXmlReader = new LargeXmlReader();
        $listener = new StrReaderListener();
        $listener->setInsertSize(3);
        $listener->setInsertIgnore(true);
        $largeXmlReader->setFilePath($fileOsm);
        $largeXmlReader->setListener($listener);
        $largeXmlReader->setBufferSize(1000);
        $progress = '';
        $largeXmlReader->setProgressListener(function($readSize, $totalSize) use (&$progress) {
            $progress .= $readSize . '/' . $totalSize . "\n";
        });

        $largeXmlReader->parse();
        $data = $listener->getData();
        $this->assertEquals($data, file_get_contents($fileSql), 'SQL generation');

        $progressActual = "0/1743\n1000/1743\n1743/1743\n";
        $this->assertEquals($progress, $progressActual, 'Progress listener');
    }
}