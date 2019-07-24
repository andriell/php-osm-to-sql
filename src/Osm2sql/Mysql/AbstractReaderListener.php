<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 13:36
 */

namespace Osm2sql\Mysql;

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
use Osm2sql\XmlReaderListener;

abstract class AbstractReaderListener extends AbstractQueryBuilder implements XmlReaderListener
{

    public function bounds(Bounds $bounds)
    {
    }

    public function node(Node $node)
    {
        $values = array();
        $values['id'] = $node->getId();
        $values['version'] = $node->getVersion();
        $values['lat'] = $node->getLat();
        $values['long'] = $node->getLon();
        $values['user'] = $node->getUser();
        $values['uid'] = $node->getUid();
        $values['visible'] = $node->getVisible() == 'true' ? 1 : 0;
        if ($node->getTimestamp()) {
            $values['timestamp'] = date('Y-m-d H:i:s', strtotime($node->getTimestamp()));
        } else {
            $values['timestamp'] = null;
        }
        $values['changeset'] = $node->getChangeSet();
        $this->insert('osm_node', $values);

    }

    public function nodeTag(NodeTag $nodeTag)
    {
        $values = array();
        $values['node_id'] = $nodeTag->getParentId();
        $values['k'] = $nodeTag->getK();
        $values['v'] = $nodeTag->getV();
        $this->insert('osm_node_tag', $values);
    }

    public function osm(Osm $osm)
    {
    }

    public function relation(Relation $relation)
    {
        $values = array();
        $values['id'] = $relation->getId();
        $values['version'] = $relation->getVersion();
        $values['user'] = $relation->getUser();
        $values['uid'] = $relation->getUid();
        $values['visible'] = $relation->getVisible() == 'true' ? 1 : 0;
        if ($relation->getTimestamp()) {
            $values['timestamp'] = date('Y-m-d H:i:s', strtotime($relation->getTimestamp()));
        } else {
            $values['timestamp'] = null;
        }
        $values['changeset'] = $relation->getChangeSet();
        $this->insert('osm_relation', $values);
    }

    public function relationMember(RelationMember $relationMember)
    {
        $values = array();
        $values['relation_id'] = $relationMember->getParentId();
        $values['type'] = $relationMember->getType();
        $values['ref'] = $relationMember->getRef();
        $values['role'] = $relationMember->getRole();
        $values['sort'] = $relationMember->getSort();
        $this->insert('osm_relation_member', $values);
    }

    public function relationTag(RelationTag $relationTag)
    {
        $values = array();
        $values['relation_id'] = $relationTag->getParentId();
        $values['k'] = $relationTag->getK();
        $values['v'] = $relationTag->getV();
        $this->insert('osm_relation_tag', $values);
    }

    public function way(Way $way)
    {
        $values = array();
        $values['id'] = $way->getId();
        $values['version'] = $way->getVersion();
        $values['user'] = $way->getUser();
        $values['uid'] = $way->getUid();
        $values['visible'] = $way->getVisible() == 'true' ? 1 : 0;
        if ($way->getTimestamp()) {
            $values['timestamp'] = date('Y-m-d H:i:s', strtotime($way->getTimestamp()));
        } else {
            $values['timestamp'] = null;
        }
        $values['changeset'] = $way->getChangeSet();
        $this->insert('osm_way', $values);
    }

    public function wayNode(WayNode $wayNode)
    {
        $values = array();
        $values['way_id'] = $wayNode->getParentId();
        $values['node_id'] = $wayNode->getRef();
        $values['sort'] = $wayNode->getSort();
        $this->insert('osm_way_node', $values);
    }

    public function wayTag(WayTag $wayTag)
    {
        $values = array();
        $values['way_id'] = $wayTag->getParentId();
        $values['k'] = $wayTag->getK();
        $values['v'] = $wayTag->getV();
        $this->insert('osm_way_tag', $values);
    }

    public function other(Other $other)
    {
    }
}