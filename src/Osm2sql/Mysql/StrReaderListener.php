<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 13:36
 */

namespace Osm2sql\Mysql;


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