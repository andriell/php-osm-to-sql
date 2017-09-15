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
     * @param $dirPath
     */
    public function __construct($dirPath)
    {
        $this->file = fopen($dirPath, 'w');
    }

    protected function write($table, $str)
    {
        fwrite($this->file, $str . ";\n");
    }


    public function end()
    {
        parent::end();
        fclose($this->file);
    }
}