<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 12:09
 */

namespace osm2sql\entity;


class WayTag
{
    private $parentId;
    private $k;
    private $v;

    /**
     * @param $parentId
     * @param array $array
     */
    public function __construct($parentId, $array)
    {
        $this->parentId = $parentId;
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
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param mixed $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
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