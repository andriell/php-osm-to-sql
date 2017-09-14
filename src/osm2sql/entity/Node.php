<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 12:09
 */

namespace osm2sql\entity;


class Node implements EntityHaveId
{
    private $id = null;
    private $lat = null;
    private $lon = null;
    private $user = null;
    private $uid = null;
    private $visible = null;
    private $version = null;
    private $changeSet = null;
    private $timestamp = null;

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
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * @param mixed $lon
     */
    public function setLon($lon)
    {
        $this->lon = $lon;
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
     * @return mixed
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * @param boolean $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    /**
     * @return boolean
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
}