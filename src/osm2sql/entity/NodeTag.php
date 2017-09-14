<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 12:09
 */

namespace osm2sql\entity;


class NodeTag
{
    private $k;
    private $v;

    /**
     * Osm constructor.
     * @param array $array
     */
    public function __construct($array)
    {
        if (isset($array['K'])) {
            $this->k = $array['K'];
        }
        if (isset($array['V'])) {
            $this->v = $array['V'];
        }
    }

    /**
     * @return mixed
     */
    public function getK()
    {
        return $this->k;
    }

    /**
     * @param mixed $k
     */
    public function setK($k)
    {
        $this->k = $k;
    }

    /**
     * @return mixed
     */
    public function getV()
    {
        return $this->v;
    }

    /**
     * @param mixed $v
     */
    public function setV($v)
    {
        $this->v = $v;
    }
}