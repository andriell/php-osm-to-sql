<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 11:58
 */

namespace osm2sql\entity;


class Bounds
{
    private $minLat;
    private $minLon;
    private $maxLat;
    private $maxLon;

    /**
     * @param array $array
     */
    public function __construct($array)
    {
        if (isset($array['MINLAT'])) {
            $this->minLat = $array['MINLAT'];
        }
        if (isset($array['MINLON'])) {
            $this->minLon = $array['MINLON'];
        }
        if (isset($array['MAXLAT'])) {
            $this->maxLat = $array['MAXLAT'];
        }
        if (isset($array['MAXLON'])) {
            $this->maxLon = $array['MAXLON'];
        }
    }

    /**
     * @return mixed
     */
    public function getMinLat()
    {
        return $this->minLat;
    }

    /**
     * @param mixed $minLat
     */
    public function setMinLat($minLat)
    {
        $this->minLat = $minLat;
    }

    /**
     * @return mixed
     */
    public function getMinLon()
    {
        return $this->minLon;
    }

    /**
     * @param mixed $minLon
     */
    public function setMinLon($minLon)
    {
        $this->minLon = $minLon;
    }

    /**
     * @return mixed
     */
    public function getMaxLat()
    {
        return $this->maxLat;
    }

    /**
     * @param mixed $maxLat
     */
    public function setMaxLat($maxLat)
    {
        $this->maxLat = $maxLat;
    }

    /**
     * @return mixed
     */
    public function getMaxLon()
    {
        return $this->maxLon;
    }

    /**
     * @param mixed $maxLon
     */
    public function setMaxLon($maxLon)
    {
        $this->maxLon = $maxLon;
    }
}