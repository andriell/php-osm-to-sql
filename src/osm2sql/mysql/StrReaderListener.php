<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 13:36
 */

namespace osm2sql\mysql;


class StrReaderListener extends AbstractReaderListener
{
    private $data;

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    protected function write($table, $str)
    {
        $this->data .= $str . ";\n";
    }
}