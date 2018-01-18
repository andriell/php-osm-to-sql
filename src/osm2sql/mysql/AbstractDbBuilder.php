<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 13:36
 */

namespace osm2sql\mysql;

abstract class AbstractDbBuilder extends AbstractQueryBuilder
{
    /** @var callable */
    private $progressListener;

    abstract protected function querySelect($sqlStr);
    abstract protected function queryUpdate($sqlStr);

    public function write($table, $sql)
    {
        $this->queryUpdate($sql);
    }

    public function deleteBuilding()
    {
        $this->queryUpdate('DELETE FROM `osm_building`');
    }

    public function insertBuilding($step = 1000, $offset = 0)
    {
        $sql = 'SELECT COUNT(rt.way_id) c FROM osm_way_tag rt WHERE rt.k IN(\'building\', \'building:use\')';
        $rows = $this->querySelect($sql);
        $totalSize = (int) array_shift($rows)['c'];
        if (is_callable($this->progressListener)) {
            call_user_func($this->progressListener, 0, $totalSize);
        }
        $doSize = 0;
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
                    call_user_func($this->progressListener, ++$doSize, $totalSize);
                }
            }
            $offset += $step;
        }
    }

    public function deleteHighway()
    {
        $this->queryUpdate('DELETE FROM `osm_highway`');
    }

    public function insertHighway($step = 1000, $offset = 0)
    {
        $sql = 'SELECT COUNT(rt.way_id) c FROM osm_way_tag rt WHERE rt.k IN(\'building\', \'building:use\')';
        $rows = $this->querySelect($sql);
        $totalSize = (int) array_shift($rows)['c'];
        if (is_callable($this->progressListener)) {
            call_user_func($this->progressListener, 0, $totalSize);
        }
        $doSize = 0;
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
                    call_user_func($this->progressListener, ++$doSize, $totalSize);
                }
            }
            $offset += $step;
        }
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