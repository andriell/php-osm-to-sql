<?php


namespace osm2sql\mysql;


use osm2sql\LargeXmlReader;

class PdoDbBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function test1()
    {
        $file = __DIR__ . '/resources/RU-MOS.osm';
        $largeXmlReader = new LargeXmlReader();
        $listener = new PdoDbBuilder('mysql:host=192.168.99.100;dbname=osm2sql;port=3307', 'root', 'password');
        $listener->setInsertSize(100);
        $listener->setInsertIgnore(true);
        $listener->setProgressListener(function ($size, $total) {
            echo 'Update DB ' . $size . ' row of ' . $total . " rows\n";
        });
        $listener->setExceptionListener(function($e, $sqlStr) {
            echo $sqlStr . "\n";
            echo $e . "\n";
        });

        $largeXmlReader->setFilePath($file);
        $largeXmlReader->setListener($listener);
        $largeXmlReader->setProgressListener(function ( $readSize, $totalSize) {
            echo  'Read file ' . $readSize . ' Mb of ' . $totalSize . " Mb\n";
        });
        
        $largeXmlReader->setStartBlock(2966);
        $largeXmlReader->parse();

        $listener->deleteHighway();
        $listener->calculateHighway();
        $listener->deleteBuilding();
        $listener->calculateBuilding();
        $listener->deletePlace();
        $listener->calculatePlace();
    }
}