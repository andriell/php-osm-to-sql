<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 13:36
 */

namespace osm2sql\mysql;

abstract class AbstractDbBuilder extends AbstractReaderListener
{
    /** @var callable */
    private $progressListener;

    abstract protected function querySelect($sqlStr);
    abstract protected function queryUpdate($sqlStr);

    public function write($table, $sql)
    {
        $this->queryUpdate($sql);
    }

    public function deleteNode()
    {
        $this->queryUpdate('TRUNCATE `osm_node_tag`');
        $this->queryUpdate('TRUNCATE `osm_node`');

    }

    public function deleteRelation()
    {
        $this->queryUpdate('TRUNCATE `osm_relation_tag`');
        $this->queryUpdate('TRUNCATE `osm_relation_member`');
        $this->queryUpdate('TRUNCATE `osm_relation`');
    }

    public function deleteWay()
    {
        $this->queryUpdate('TRUNCATE `osm_way_tag`');
        $this->queryUpdate('TRUNCATE `osm_way_node`');
        $this->queryUpdate('TRUNCATE `osm_way`');
    }

    public function deleteBuilding()
    {
        $this->queryUpdate('TRUNCATE `osm_building`');
    }

    public function calculateBuilding($step = 1000, $offset = 0)
    {
        $sql = 'SELECT COUNT(rt.way_id) c FROM osm_way_tag rt WHERE rt.k IN(\'building\', \'building:use\')';
        $rows = $this->querySelect($sql);
        $totalSize = (int) array_shift($rows)['c'];
        $progress = $offset;
        if (is_callable($this->progressListener)) {
            call_user_func($this->progressListener, 0, $totalSize);
        }
        while ($offset < $totalSize) {
            $sql = '
                SELECT
                    wt1.way_id,
                    wt1.v,
                    (SELECT wt2.v FROM osm_way_tag wt2 WHERE wt2.way_id = wt1.way_id AND wt2.k = \'addr:street\') street,
                    (SELECT wt2.v FROM osm_way_tag wt2 WHERE wt2.way_id = wt1.way_id AND wt2.k = \'addr:housenumber\') housenumber,
                    (SELECT GROUP_CONCAT(CONCAT(\'[\', n.lat, \',\', n.long, \']\') ORDER BY wn.sort SEPARATOR \',\')
                        FROM osm_way_node wn
                        JOIN osm_node n ON n.id = wn.node_id
                        WHERE wn.way_id = wt1.way_id GROUP BY wn.way_id) points
                FROM osm_way_tag wt1
                WHERE wt1.k IN(\'building\', \'building:use\')
                ORDER BY wt1.way_id
                LIMIT ' . intval($offset) . ', ' . intval($step);
            $rows = $this->querySelect($sql);
            foreach ($rows as $row) {
                $progress++;
                if (empty($row['points'])) {
                    continue;
                }
                $points = json_decode('[' . $row['points'] . ']', true);
                if (count($points) == 1) {
                    $points[] = [$points[0][0] + 0.0000001, $points[0][1]];
                    $points[] = [$points[0][0] + 0.0000001, $points[0][1] + 0.0000001];
                    $points[] = [$points[0][0], $points[0][1] + 0.0000001];
                }
                $points[] = $points[0];
                $this->insert('osm_building', [
                    'way_id' => $row['way_id'],
                    'type' => $row['v'],
                    'street' => $row['street'],
                    'housenumber' => $row['housenumber'],
                    'm' => new GeomMultiPolygon([[$points]]),
                ]);
                if (is_callable($this->progressListener)) {
                    call_user_func($this->progressListener, $progress, $totalSize);
                }
            }
            $offset += $step;
        }
        $this->end();
    }

    public function deleteHighway()
    {
        $this->queryUpdate('TRUNCATE `osm_highway`');
    }

    public function calculateHighway($step = 1000, $offset = 0)
    {
        $sql = 'SELECT COUNT(rt.way_id) c FROM osm_way_tag rt WHERE rt.k IN(\'highway\')';
        $rows = $this->querySelect($sql);
        $totalSize = (int) array_shift($rows)['c'];
        if (is_callable($this->progressListener)) {
            call_user_func($this->progressListener, 0, $totalSize);
        }
        $progress = $offset;
        while ($offset < $totalSize) {
            $sql = '
                SELECT
                    wt1.way_id,
                    wt1.v,
                    (SELECT wt2.v FROM osm_way_tag wt2 WHERE wt2.way_id = wt1.way_id AND wt2.k = \'name\') `name`,
                    (SELECT wt2.v FROM osm_way_tag wt2 WHERE wt2.way_id = wt1.way_id AND wt2.k = \'ref\') ref,
                    (SELECT GROUP_CONCAT(CONCAT(\'[\', n.lat, \',\', n.long, \']\') ORDER BY wn.sort SEPARATOR \',\')
                        FROM osm_way_node wn
                        JOIN osm_node n ON n.id = wn.node_id
                        WHERE wn.way_id = wt1.way_id GROUP BY wn.way_id) points
                FROM osm_way_tag wt1
                WHERE wt1.k IN(\'highway\')
                ORDER BY wt1.way_id
                LIMIT ' . intval($offset) . ', ' . intval($step);
            $rows = $this->querySelect($sql);
            foreach ($rows as $row) {
                $progress++;
                if (empty($row['points'])) {
                    continue;
                }
                $points = json_decode('[' . $row['points'] . ']', true);
                $this->insert('osm_highway', [
                    'way_id' => $row['way_id'],
                    'type' => $row['v'],
                    'name' => $row['name'],
                    'ref' => $row['ref'],
                    'l' => new GeomMultiLineString([$points]),
                ]);
                if (is_callable($this->progressListener)) {
                    call_user_func($this->progressListener, $progress, $totalSize);
                }
            }
            $offset += $step;
        }
        $this->end();
    }

    public function deletePlace()
    {
        $this->queryUpdate('TRUNCATE `osm_place`');
    }

    public function calculatePlace($offset = 0)
    {
        $sql = 'SELECT COUNT(rt.relation_id) c FROM osm_relation_tag rt WHERE rt.k = \'place\'';
        $rows = $this->querySelect($sql);
        $totalSize = (int) array_shift($rows)['c'];
        if (is_callable($this->progressListener)) {
            call_user_func($this->progressListener, 0, $totalSize);
        }
        $step = 1;
        $progress = $offset;
        while ($offset < $totalSize) {
            $sql = '
                SELECT 
                    rt1.relation_id,
                    rt1.v,
                    (SELECT rt2.v FROM osm_relation_tag rt2 WHERE rt2.relation_id = rt1.relation_id AND rt2.k = \'name\') `name`,
                    (SELECT rt2.v FROM osm_relation_tag rt2 WHERE rt2.relation_id = rt1.relation_id AND rt2.k = \'old_name\') old_name,
                    (SELECT GROUP_CONCAT(CONCAT(\'{"type":"\', rm.`type`, \'","role":"\', rm.role, \'","ref":\', rm.ref ,\'}\') ORDER BY rm.sort SEPARATOR \',\') FROM osm_relation_member rm WHERE rm.relation_id = rt1.relation_id) member
                FROM osm_relation_tag rt1
                WHERE rt1.k = IN (\'place\', \'boundary\')
                LIMIT ' . intval($offset) . ', ' . intval($step);
            $rows = $this->querySelect($sql);
            foreach ($rows as $row) {
                $progress++;
                if (empty($row['member'])) {
                    continue;
                }
                $members = json_decode('[' . $row['member'] . ']', true);
                $outer = [];
                $inner = [];
                foreach ($members as $member) {
                    if ($member['type'] == 'way') {
                        $points = $this->getWayPoints($member['ref']);
                        if ($points) {
                            if ($member['role'] == 'outer') {
                                $outer[] = [$points];
                            } elseif ($member['role'] == 'inner') {
                                $inner[] = [$points];
                            }
                        }
                    }
                }
                $this->insert('osm_place', [
                    'relation_id' => $row['relation_id'],
                    'type' => $row['v'],
                    'name' => $row['name'],
                    'old_name' => $row['old_name'],
                    'outer' => new GeomMultiPolygon($outer),
                    'inner' => new GeomMultiPolygon($inner),
                ]);
                if (is_callable($this->progressListener)) {
                    call_user_func($this->progressListener, $progress, $totalSize);
                }
            }
            $offset += $step;
        }
        $this->end();
    }

    private function getWayPoints($wayId) {
        $sql = '
            SELECT GROUP_CONCAT(CONCAT(\'[\', n.lat, \',\', n.long, \']\') ORDER BY wn.sort SEPARATOR \',\') points
                FROM osm_way_node wn
                JOIN osm_node n ON n.id = wn.node_id
                WHERE wn.way_id = ' . intval($wayId) . ' GROUP BY wn.way_id';
        $rows = $this->querySelect($sql);
        if (empty($rows)) {
            return [];
        }
        $row = array_shift($rows);
        if (empty($row['points'])) {
            return [];
        }
        $points = json_decode('[' . $row['points'] . ']', true);
        if (count($points) == 1) {
            $points[] = [$points[0][0] + 0.0000001, $points[0][1]];
            $points[] = [$points[0][0] + 0.0000001, $points[0][1] + 0.0000001];
            $points[] = [$points[0][0], $points[0][1] + 0.0000001];
        }
        $points[] = $points[0];
        return $points;
    }

    /**
     * @return callable
     */
    public function getProgressListener()
    {
        return $this->progressListener;
    }

    /**
     * @param callable $progressListener
     */
    public function setProgressListener($progressListener)
    {
        $this->progressListener = $progressListener;
    }
}