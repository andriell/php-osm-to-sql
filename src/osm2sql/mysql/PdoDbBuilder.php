<?php
/**
 * Created by PhpStorm.
 * User: am_ry
 * Date: 18.01.2018
 * Time: 14:03
 */

namespace osm2sql\mysql;


class PdoDbBuilder extends AbstractDbBuilder
{
    /** @var \PDO */
    private $connection;

    public function __construct($dsn, $user, $password, $options = [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"])
    {
        $this->connection = new \PDO($dsn, $user, $password, $options);
    }

    protected function querySelect($sqlStr)
    {
        $rows = $this->connection->query($sqlStr);
        $r = [];
        foreach ($rows as $row) {
            $r[] = $row;
        }
        return $r;
    }

    protected function queryUpdate($sqlStr)
    {
        return $this->connection->exec($sqlStr);
    }
}