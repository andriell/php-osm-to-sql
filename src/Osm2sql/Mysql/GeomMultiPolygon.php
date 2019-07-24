<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 18.01.2018
 * Time: 11:58
 */

namespace Osm2sql\Mysql;


class GeomMultiPolygon extends GeomJson
{
    public function __construct(array $data)
    {
        parent::__construct(array('type' => 'MultiPolygon', 'coordinates' => $data));
    }
}