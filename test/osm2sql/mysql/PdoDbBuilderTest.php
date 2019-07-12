<?php


namespace osm2sql\mysql;


use osm2sql\LargeXmlReader;

class PdoDbBuilderTest extends \PHPUnit_Framework_TestCase
{

    private $largeXmlReader;
    private $listener;

    /**
     * PdoDbBuilderTest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $file = __DIR__ . '/../../../resources/RU-MOS.osm';
        $this->largeXmlReader = new LargeXmlReader();
        $this->listener = new PdoDbBuilder('mysql:host=192.168.99.100;dbname=osm2sql;port=3307', 'root', 'password');
        $this->listener->setInsertSize(100);
        $this->listener->setInsertIgnore(true);
        $this->listener->setProgressListener(array($this, 'updateProgressListener'));
        $this->listener->setExceptionListener(array($this, 'exceptionListener'));

        $this->largeXmlReader->setFilePath($file);
        $this->largeXmlReader->setListener($this->listener);
        $this->largeXmlReader->setProgressListener(array($this, 'readProgressListener'));
    }

    public function updateProgressListener($size, $total)
    {
        echo 'Update DB ' . $size . ' row of ' . $total . ' rows' . "\n";
        ob_flush();
    }

    public function readProgressListener($readSize, $totalSize)
    {
        echo 'Read file ' . $readSize . ' Mb of ' . $totalSize . ' Mb' . "\n";
        ob_flush();
    }

    public function exceptionListener($e, $sqlStr) {
        echo $e;
        echo $sqlStr;
        ob_flush();
    }

    public function testClean()
    {
        $this->listener->deleteNode();
        $this->listener->deleteRelation();
        $this->listener->deleteWay();
    }

    public function testParse()
    {
        $this->largeXmlReader->setStartBlock(0);
        $this->largeXmlReader->parse();
    }

    public function testCalculate()
    {
        $this->listener->deleteHighway();
        $this->listener->calculateHighway();
        $this->listener->deleteBuilding();
        $this->listener->calculateBuilding();
        $this->listener->deletePlace();
        $this->listener->calculatePlace();
    }
}