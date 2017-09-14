<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 11:54
 */

namespace osm2sql\entity;


class Osm
{
    private $version;
    private $generator;

    /**
     * Osm constructor.
     * @param array $array
     */
    public function __construct($array)
    {
        if (isset($array['VERSION'])) {
            $this->version = $array['VERSION'];
        }
        if (isset($array['GENERATOR'])) {
            $this->generator = $array['GENERATOR'];
        }
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return mixed
     */
    public function getGenerator()
    {
        return $this->generator;
    }

    /**
     * @param mixed $generator
     */
    public function setGenerator($generator)
    {
        $this->generator = $generator;
    }
}