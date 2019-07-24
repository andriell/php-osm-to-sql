<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 16.01.2018
 * Time: 15:06
 */

namespace Osm2sql\Entity;


class Other
{
    private $name = '';
    private $attr = array();

    /**
     * Entity constructor.
     * @param string $name
     * @param array $attr
     */
    public function __construct($name, array $attr = array())
    {
        $this->name = $name;
        $this->attr = $attr;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param bool|string $name
     * @param mixed $default
     * @return array
     */
    public function getAttr($name = false, $default = false)
    {
        if (empty($name)) {
            return $this->attr;
        }
        return isset($this->attr[$name]) ? $this->attr[$name] : $default;
    }


}