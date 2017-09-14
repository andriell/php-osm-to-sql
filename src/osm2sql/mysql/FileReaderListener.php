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

class FileReaderListener implements XmlReaderListener
{
    private $file;

    /**
     * FileReaderListener constructor.
     * @param $filePath
     */
    public function __construct($filePath)
    {
        $this->file = fopen($filePath, 'w');
    }


    private function insert($table, $values) {
        $str1 = '';
        $str2 = '';
        $prefix = '';
        foreach ($values as $key => $val) {
            $str1 .= $prefix . '`' . $key . '`';
            if (empty($val)) {
                $str2 .= $prefix . 'NULL';
            } else {
                $str2 .= $prefix . '\'' . str_replace('\'', '', $val) . '\'';
            }
            $prefix = ', ';
        }
        $sql = 'INSERT INTO `' . $table . '` (' . $str1 . ') VALUES (' . $str2 . ');' . "\n";
        fwrite($this->file, $sql);
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
        $values['visible'] = $node->getVisible() ? 1 : 0;
        $values['timestamp'] = date('Y-m-d H:i:s', strtotime($node->getTimestamp()));
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
        $values['visible'] = $relation->getVisible() ? 1 : 0;
        $values['timestamp'] = date('Y-m-d H:i:s', strtotime($relation->getTimestamp()));
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
        $values['visible'] = $way->getVisible() ? 1 : 0;
        $values['timestamp'] = date('Y-m-d H:i:s', strtotime($way->getTimestamp()));
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
        fclose($this->file);
    }
}