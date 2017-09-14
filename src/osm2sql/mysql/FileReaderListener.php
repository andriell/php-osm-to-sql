<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 13:36
 */

namespace osm2sql\mysql;

class FileReaderListener extends AbstractReaderListener
{
    private $file;

    /**
     * FileReaderListener constructor.
     * @param $filePath
     */
    public function __construct($filePath)
    {
        $this->file = fopen($filePath, 'w');
    }

    protected function write($str)
    {
        fwrite($this->file, $str);
    }


    public function end()
    {
        fclose($this->file);
    }
}