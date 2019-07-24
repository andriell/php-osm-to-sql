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

/**
 * Group of OSMPrimitives. All primitives in a group must be the same type.
 *
 * Generated from protobuf message <code>osm2sql.pbf.PrimitiveGroup</code>
 */
class PrimitiveGroup extends Message
{
    /**
     * Generated from protobuf field <code>repeated .osm2sql.pbf.Node nodes = 1;</code>
     */
    private $nodes;
    /**
     * Generated from protobuf field <code>.osm2sql.pbf.DenseNodes dense = 2;</code>
     */
    private $dense = null;
    /**
     * Generated from protobuf field <code>repeated .osm2sql.pbf.Way ways = 3;</code>
     */
    private $ways;
    /**
     * Generated from protobuf field <code>repeated .osm2sql.pbf.Relation relations = 4;</code>
     */
    private $relations;
    /**
     * Generated from protobuf field <code>repeated .osm2sql.pbf.ChangeSet changesets = 5;</code>
     */
    private $changesets;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type Node[]|RepeatedField $nodes
     *     @type DenseNodes $dense
     *     @type Way[]|RepeatedField $ways
     *     @type Relation[]|RepeatedField $relations
     *     @type ChangeSet[]|RepeatedField $changesets
     * }
     */
    public function __construct($data = NULL) {
        Osmformat::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>repeated .osm2sql.pbf.Node nodes = 1;</code>
     * @return RepeatedField
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * Generated from protobuf field <code>repeated .osm2sql.pbf.Node nodes = 1;</code>
     * @param Node[]|RepeatedField $var
     * @return $this
     * @throws Exception
     */
    public function setNodes($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, GPBType::MESSAGE, Node::class);
        $this->nodes = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.osm2sql.pbf.DenseNodes dense = 2;</code>
     * @return DenseNodes
     */
    public function getDense()
    {
        return $this->dense;
    }

    /**
     * Generated from protobuf field <code>.osm2sql.pbf.DenseNodes dense = 2;</code>
     * @param DenseNodes $var
     * @return $this
     * @throws Exception
     */
    public function setDense($var)
    {
        GPBUtil::checkMessage($var, DenseNodes::class);
        $this->dense = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .osm2sql.pbf.Way ways = 3;</code>
     * @return RepeatedField
     */
    public function getWays()
    {
        return $this->ways;
    }

    /**
     * Generated from protobuf field <code>repeated .osm2sql.pbf.Way ways = 3;</code>
     * @param Way[]|RepeatedField $var
     * @return $this
     * @throws Exception
     */
    public function setWays($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, GPBType::MESSAGE, Way::class);
        $this->ways = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .osm2sql.pbf.Relation relations = 4;</code>
     * @return RepeatedField
     */
    public function getRelations()
    {
        return $this->relations;
    }

    /**
     * Generated from protobuf field <code>repeated .osm2sql.pbf.Relation relations = 4;</code>
     * @param Relation[]|RepeatedField $var
     * @return $this
     * @throws Exception
     */
    public function setRelations($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, GPBType::MESSAGE, Relation::class);
        $this->relations = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .osm2sql.pbf.ChangeSet changesets = 5;</code>
     * @return RepeatedField
     */
    public function getChangesets()
    {
        return $this->changesets;
    }

    /**
     * Generated from protobuf field <code>repeated .osm2sql.pbf.ChangeSet changesets = 5;</code>
     * @param ChangeSet[]|RepeatedField $var
     * @return $this
     * @throws Exception
     */
    public function setChangesets($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, GPBType::MESSAGE, ChangeSet::class);
        $this->changesets = $arr;

        return $this;
    }

}

