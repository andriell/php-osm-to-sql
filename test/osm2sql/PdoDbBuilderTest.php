<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 18.01.2018
 * Time: 14:13
 */

namespace osm2sql;


use osm2sql\mysql\PdoDbBuilder;

class PdoDbBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function test1()
    {
        ini_set('memory_limit', '100M');

        $listener = new PdoDbBuilder('mysql:host=localhost;dbname=osm;port=3310', 'iebr2', 'ZXpzYh5tTjwKGI6D');
        $listener->setInsertSize(100);
        $listener->setInsertIgnore(true);
        $listener->setProgressListener(function ($size, $total) {
            echo $size . ' ' . $total . "\n";
        });
        $listener->replaceAll();
    }
}