<?php


namespace Osm2sql\Pbf;


class BlobHeaderTest extends \PHPUnit_Framework_TestCase
{
    public function test1()
    {
        $blobHeader = new BlobHeader();
        $blobHeader->setDatasize(4);
        $blobHeader->setIndexdata(hex2bin('74657374'));
        $blobHeader->setType(1);
        $this->assertEquals(hex2bin('0a01311204746573741804'), $blobHeader->serializeToString());
    }
}
