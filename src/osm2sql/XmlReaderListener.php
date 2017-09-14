<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 13:25
 */

namespace osm2sql;


use osm2sql\entity\Bounds;
use osm2sql\entity\Node;
use osm2sql\entity\NodeTag;
use osm2sql\entity\Osm;
use osm2sql\entity\Relation;
use osm2sql\entity\RelationMember;
use osm2sql\entity\RelationTag;
use osm2sql\entity\Way;
use osm2sql\entity\WayNode;
use osm2sql\entity\WayTag;

interface XmlReaderListener
{
    public function bounds(Bounds $bounds);
    public function node(Node $node);
    public function nodeTag(NodeTag $nodeTag);
    public function osm(Osm $osm);
    public function relation(Relation $relation);
    public function relationMember(RelationMember $relationMember);
    public function relationTag(RelationTag $relationTag);
    public function way(Way $way);
    public function wayNode(WayNode $wayNode);
    public function wayTag(WayTag $wayTag);
}