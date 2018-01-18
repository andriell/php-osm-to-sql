<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 18.01.2018
 * Time: 11:58
 */

namespace osm2sql\mysql;


class GeomMultiLineString extends GeomJson
{
    public function __construct(array $data)
    {
        parent::__construct(['type' => 'MultiLineString', 'coordinates' => $data]);
    }
}