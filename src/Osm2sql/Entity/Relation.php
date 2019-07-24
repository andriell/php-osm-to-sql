<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 12:20
 */

namespace Osm2sql\Entity;


class Relation implements EntityHaveId, EntityHaveNode
{
    private $id = null;
    private $user = null;
    private $uid = null;
    private $visible = null;
    private $version = null;
    private $changeSet = null;
    private $timestamp = null;
    private $sort = 0;

    /**
     * @param array $array
     */
    public function __construct($array)
    {
        if (isset($array['ID'])) {
            $this->id = $array['ID'];
        }
        if (isset($array['LAT'])) {
            $this->lat = $array['LAT'];
        }
        if (isset($array['LON'])) {
            $this->lon = $array['LON'];
        }
        if (isset($array['USER'])) {
            $this->user = $array['USER'];
        }
        if (isset($array['UID'])) {
            $this->uid = $array['UID'];
        }
        if (isset($array['VISIBLE'])) {
            $this->visible = strtolower($array['VISIBLE']) == 'true';
        }
        if (isset($array['VERSION'])) {
            $this->version = $array['VERSION'];
        }
        if (isset($array['CHANGESET'])) {
            $this->changeSet = $array['CHANGESET'];
        }
        if (isset($array['TIMESTAMP'])) {
            $this->timestamp = $array['TIMESTAMP'];
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param mixed $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return bool
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * @param bool $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    /**
     * @return bool
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
    public function getChangeSet()
    {
        return $this->changeSet;
    }

    /**
     * @param mixed $changeSet
     */
    public function setChangeSet($changeSet)
    {
        $this->changeSet = $changeSet;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function nextSort()
    {
        return $this->sort++;
    }
}