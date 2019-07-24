<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: resources/osmformat.proto

namespace osm2sql\pbf;

use Exception;
use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\Message;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;
use GPBMetadata\Resources\Osmformat;
use osm2sql\pbf\Relation\MemberType;

/**
 * Generated from protobuf message <code>osm2sql.pbf.Relation</code>
 */
class Relation extends Message
{
    /**
     * Generated from protobuf field <code>int64 id = 1;</code>
     */
    private $id = 0;
    /**
     * Parallel arrays.
     *
     * Generated from protobuf field <code>repeated uint32 keys = 2 [packed = true];</code>
     */
    private $keys;
    /**
     * Generated from protobuf field <code>repeated uint32 vals = 3 [packed = true];</code>
     */
    private $vals;
    /**
     * Generated from protobuf field <code>.osm2sql.pbf.Info info = 4;</code>
     */
    private $info = null;
    /**
     * Parallel arrays
     *
     * Generated from protobuf field <code>repeated int32 roles_sid = 8 [packed = true];</code>
     */
    private $roles_sid;
    /**
     * DELTA encoded
     *
     * Generated from protobuf field <code>repeated sint64 memids = 9 [packed = true];</code>
     */
    private $memids;
    /**
     * Generated from protobuf field <code>repeated .osm2sql.pbf.Relation.MemberType types = 10 [packed = true];</code>
     */
    private $types;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int|string $id
     *     @type int[]|RepeatedField $keys
     *           Parallel arrays.
     *     @type int[]|RepeatedField $vals
     *     @type Info $info
     *     @type int[]|RepeatedField $roles_sid
     *           Parallel arrays
     *     @type int[]|string[]|RepeatedField $memids
     *           DELTA encoded
     *     @type int[]|RepeatedField $types
     * }
     */
    public function __construct($data = NULL) {
        Osmformat::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>int64 id = 1;</code>
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Generated from protobuf field <code>int64 id = 1;</code>
     * @param int|string $var
     * @return $this
     * @throws Exception
     */
    public function setId($var)
    {
        GPBUtil::checkInt64($var);
        $this->id = $var;

        return $this;
    }

    /**
     * Parallel arrays.
     *
     * Generated from protobuf field <code>repeated uint32 keys = 2 [packed = true];</code>
     * @return RepeatedField
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * Parallel arrays.
     *
     * Generated from protobuf field <code>repeated uint32 keys = 2 [packed = true];</code>
     * @param int[]|RepeatedField $var
     * @return $this
     * @throws Exception
     */
    public function setKeys($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, GPBType::UINT32);
        $this->keys = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated uint32 vals = 3 [packed = true];</code>
     * @return RepeatedField
     */
    public function getVals()
    {
        return $this->vals;
    }

    /**
     * Generated from protobuf field <code>repeated uint32 vals = 3 [packed = true];</code>
     * @param int[]|RepeatedField $var
     * @return $this
     * @throws Exception
     */
    public function setVals($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, GPBType::UINT32);
        $this->vals = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.osm2sql.pbf.Info info = 4;</code>
     * @return Info
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Generated from protobuf field <code>.osm2sql.pbf.Info info = 4;</code>
     * @param Info $var
     * @return $this
     * @throws Exception
     */
    public function setInfo($var)
    {
        GPBUtil::checkMessage($var, Info::class);
        $this->info = $var;

        return $this;
    }

    /**
     * Parallel arrays
     *
     * Generated from protobuf field <code>repeated int32 roles_sid = 8 [packed = true];</code>
     * @return RepeatedField
     */
    public function getRolesSid()
    {
        return $this->roles_sid;
    }

    /**
     * Parallel arrays
     *
     * Generated from protobuf field <code>repeated int32 roles_sid = 8 [packed = true];</code>
     * @param int[]|RepeatedField $var
     * @return $this
     * @throws Exception
     */
    public function setRolesSid($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, GPBType::INT32);
        $this->roles_sid = $arr;

        return $this;
    }

    /**
     * DELTA encoded
     *
     * Generated from protobuf field <code>repeated sint64 memids = 9 [packed = true];</code>
     * @return RepeatedField
     */
    public function getMemids()
    {
        return $this->memids;
    }

    /**
     * DELTA encoded
     *
     * Generated from protobuf field <code>repeated sint64 memids = 9 [packed = true];</code>
     * @param int[]|string[]|RepeatedField $var
     * @return $this
     * @throws Exception
     */
    public function setMemids($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, GPBType::SINT64);
        $this->memids = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .osm2sql.pbf.Relation.MemberType types = 10 [packed = true];</code>
     * @return RepeatedField
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Generated from protobuf field <code>repeated .osm2sql.pbf.Relation.MemberType types = 10 [packed = true];</code>
     * @param int[]|RepeatedField $var
     * @return $this
     * @throws Exception
     */
    public function setTypes($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, GPBType::ENUM, MemberType::class);
        $this->types = $arr;

        return $this;
    }

}

