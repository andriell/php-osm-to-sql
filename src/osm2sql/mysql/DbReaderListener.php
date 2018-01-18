<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 14.09.2017
 * Time: 13:36
 */

namespace osm2sql\mysql;

abstract class DbReaderListener extends AbstractReaderListener
{
    /** @var callable */
    private $progressListener;

    abstract protected function doSelect($sqlStr);
    abstract protected function doInsert($sqlStr);
    abstract protected function doUpdate($sqlStr);
    abstract protected function doDelete($sqlStr);

    public function write($table, $sql)
    {
        $this->doInsert($sql);
    }

    public function deleteBuilding()
    {
        $this->doDelete('DELETE FROM `osm_building`;');
    }

    public function insertBuilding($step = 1000)
    {
        $sql = 'SELECT COUNT(rt.way_id) c FROM osm_way_tag rt WHERE rt.k IN(\'building\', \'building:use\')';
        $rows = $this->doSelect($sql);
        $totalSize = (int) array_shift($rows)['c'];
        if (is_callable($this->progressListener)) {
            call_user_func($this->progressListener, 0, $totalSize);
        }
        $offset = 0;
        $doSize = 0;
        while ($offset < $totalSize) {
            $sql = '
                SELECT
                    wt1.way_id,
                    wt1.k,
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
            $rows = $this->doSelect($sql);
            foreach ($rows as $row) {
                if (empty($row['points'])) {
                    continue;
                }
                $points = json_decode('{' . $row['points'] . '}', true);
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
                    'm' => new GeomMultiPolygon([$points]),
                ]);
                if (is_callable($this->progressListener)) {
                    call_user_func($this->progressListener, ++$doSize, $totalSize);
                }
            }
            $offset += $step;
        }
    }
}