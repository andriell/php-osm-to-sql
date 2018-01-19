<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 18.01.2018
 * Time: 11:13
 */

namespace osm2sql\mysql;


abstract class AbstractQueryBuilder
{
    private $tables = [];
    private $insertSize = 100;
    private $insertIgnore = true;

    abstract protected function write($table, $str);

    protected function buildSql($table)
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
                } elseif ($val instanceof GeomJson) {
                    $sql2 .= $p2 . "ST_GeomFromGeoJSON('" . str_replace("'", "''", $val->__toString()) . "')";
                } else {
                    $sql2 .= $p2 . "'" . str_replace(["'", '\\'], ["''", '\\\\'], $val) . "'";
                }
                $p2 = ',';
            }
            $sql2 .= ')';
            $p1 = ',';
        }
        $this->tables[$table] = [];
        $sql = 'INSERT ' . ($this->insertIgnore ? 'IGNORE' : '') . ' INTO `' . $table . '` (' . $sql1 . ') VALUES ' . $sql2;
        $this->write($table, $sql);
    }

    public function insert($table, $values)
    {
        $this->tables[$table][] = $values;
        if (count($this->tables[$table]) >= $this->insertSize) {
            $this->buildSql($table);
        }
    }

    public function end()
    {
        foreach ($this->tables as $tableName => $null) {
            $this->buildSql($tableName);
        }
    }

    /**
     * @return bool
     */
    public function isInsertIgnore()
    {
        return $this->insertIgnore;
    }

    /**
     * @param bool $insertIgnore
     */
    public function setInsertIgnore($insertIgnore)
    {
        $this->insertIgnore = $insertIgnore;
    }

    /**
     * @return int
     */
    public function getInsertSize()
    {
        return $this->insertSize;
    }

    /**
     * @param int $insertSize
     */
    public function setInsertSize($insertSize)
    {
        $this->insertSize = $insertSize;
    }
}