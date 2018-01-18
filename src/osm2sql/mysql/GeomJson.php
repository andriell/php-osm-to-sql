<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 18.01.2018
 * Time: 11:56
 */

namespace osm2sql\mysql;


class GeomJson
{
    private $data = [];

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