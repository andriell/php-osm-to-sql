<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 13:36
 */

namespace osm2sql\mysql;

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
use osm2sql\XmlReaderListener;

abstract class AbstractReaderListener implements XmlReaderListener
{
    private $tables = [];
    private $insertSize = 100;

    abstract protected function write($table, $str);

    protected function writeTable($table)
    {
        if (!isset($this->tables[$table])) {
            return;
        }
        if (empty($this->tables[$table])) {
            return;
        }

        $sql1 = '';
        $sql2 = '';
        $p1 = '';
        foreach ($this->tables[$table] as $values) {
            $sql1 = '';
            $sql2 .= $p1 . '(';
            $p2 = '';
            foreach ($values as $key => $val) {
                $sql1 .= $p2 . '`' . $key . '`';
                if ($val === null) {
                    $sql2 .= $p2 . 'NULL';
                } else {
                    $sql2 .= $p2 . "'" . str_replace("'", "''", $val) . "'";
                }
                $p2 = ',';
            }
            $sql2 .= ')';
            $p1 = ',';
        }
        $this->tables[$table] = [];
        $sql = 'INSERT INTO `' . $table . '` (' . $sql1 . ') VALUES ' . $sql2 . ';' . "\n";
        $this->write($table, $sql);
    }

    protected function insert($table, $values)
    {
        $this->tables[$table][] = $values;
        if (count($this->tables[$table]) >= $this->insertSize) {
            $this->writeTable($table);
        }
    }

    public function bounds(Bounds $bounds)
    {
    }

    public function node(Node $node)
    {
        $values = [];
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
        $this->insert('node', $values);

    }

    public function nodeTag(NodeTag $nodeTag)
    {
        $values = [];
        $values['node_id'] = $nodeTag->getParentId();
        $values['k'] = $nodeTag->getK();
        $values['v'] = $nodeTag->getV();
        $this->insert('node_tag', $values);
    }

    public function osm(Osm $osm)
    {
    }

    public function relation(Relation $relation)
    {
        $values = [];
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
        $this->insert('relation', $values);
    }

    public function relationMember(RelationMember $relationMember)
    {
        $values = [];
        $values['relation_id'] = $relationMember->getParentId();
        $values['type'] = $relationMember->getType();
        $values['ref'] = $relationMember->getRef();
        $values['role'] = $relationMember->getRole();
        $this->insert('relation_member', $values);
    }

    public function relationTag(RelationTag $relationTag)
    {
        $values = [];
        $values['relation_id'] = $relationTag->getParentId();
        $values['k'] = $relationTag->getK();
        $values['v'] = $relationTag->getV();
        $this->insert('relation_tag', $values);
    }

    public function way(Way $way)
    {
        $values = [];
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
        $this->insert('way', $values);
    }

    public function wayNode(WayNode $wayNode)
    {
        $values = [];
        $values['way_id'] = $wayNode->getParentId();
        $values['node_id'] = $wayNode->getRef();
        $this->insert('way_node', $values);
    }

    public function wayTag(WayTag $wayTag)
    {
        $values = [];
        $values['way_id'] = $wayTag->getParentId();
        $values['k'] = $wayTag->getK();
        $values['v'] = $wayTag->getV();
        $this->insert('way_tag', $values);
    }

    public function end()
    {
        foreach ($this->tables as $tableName => $null) {
            $this->writeTable($tableName);
        }
    }
}