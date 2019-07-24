<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 18.01.2018
 * Time: 11:56
 */

namespace Osm2sql\Mysql;


class GeomJson
{
    private $data = array();

    /**
     * GeomJson constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    function __toString()
    {
        return json_encode($this->data);
    }
}