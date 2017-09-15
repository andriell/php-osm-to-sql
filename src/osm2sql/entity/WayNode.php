<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 12:09
 */

namespace osm2sql\entity;


class WayNode
{
    private $parentId = null;
    private $ref = null;
    private $sort = null;

    /**
     * @param $parentId
     * @param array $array
     */
    public function __construct($parentId, $array)
    {
        $this->parentId = $parentId;
        if (isset($array['REF'])) {
            $this->ref = $array['REF'];
        }
        if (isset($array['SORT'])) {
            $this->sort = $array['SORT'];
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
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param mixed $ref
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    }

    /**
     * @return mixed|null
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param mixed|null $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }
}