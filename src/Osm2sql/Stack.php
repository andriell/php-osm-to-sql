<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 16:13
 */

namespace Osm2sql;


class Stack
{
    private $data = array();
    private $index = -1;

    public function push($e)
    {
        $this->index++;
        $this->data[$this->index] = $e;
    }

    public function pop()
    {
        $e = $this->data[$this->index];
        unset($this->data[$this->index]);
        $this->index--;
        return $e;
    }

    public function top()
    {
        return $this->data[$this->index];
    }

    public function size()
    {
        return $this->index + 1;
    }
}