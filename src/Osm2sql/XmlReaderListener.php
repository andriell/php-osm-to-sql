<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 13:25
 */

namespace Osm2sql;


use Osm2sql\Entity\Bounds;
use Osm2sql\Entity\Node;
use Osm2sql\Entity\NodeTag;
use Osm2sql\Entity\Osm;
use Osm2sql\Entity\Other;
use Osm2sql\Entity\Relation;
use Osm2sql\Entity\RelationMember;
use Osm2sql\Entity\RelationTag;
use Osm2sql\Entity\Way;
use Osm2sql\Entity\WayNode;
use Osm2sql\Entity\WayTag;

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
    public function other(Other $other);
    public function end();
}