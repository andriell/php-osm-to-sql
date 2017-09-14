<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 12:09
 */

namespace osm2sql\entity;


class RelationMember
{
    private $parentId = null;
    private $type = null;
    private $ref = null;
    private $role = null;

    /**
     * @param $parentId
     * @param array $array
     */
    public function __construct($parentId, $array)
    {
        $this->parentId = $parentId;
        if (isset($array['TYPE'])) {
            $this->type = $array['TYPE'];
        }
        if (isset($array['REF'])) {
            $this->ref = $array['REF'];
        }
        if (isset($array['ROLE'])) {
            $this->role = $array['ROLE'];
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
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
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }
}