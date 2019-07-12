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
    /** @var callable */
    private $exceptionListener;

    public function __construct($dsn, $user, $password, $options = array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"))
    {
        $this->connection = new \PDO($dsn, $user, $password, $options);
    }

    /**
     * @param $sqlStr
     * @return array
     * @throws \Exception
     */
    protected function querySelect($sqlStr)
    {
        $r = array();
        try {
            $rows = $this->connection->query($sqlStr);
            foreach ($rows as $row) {
                $r[] = $row;
            }
        } catch (\Exception $e) {
            if (is_callable($this->exceptionListener)) {
                call_user_func($this->exceptionListener, $e, $sqlStr);
            } else {
                throw $e;
            }
        }
        return $r;
    }

    /**
     * @param $sqlStr
     * @return int
     * @throws \Exception
     */
    protected function queryUpdate($sqlStr)
    {
        try {
            return $this->connection->exec($sqlStr);
        } catch (\Exception $e) {
            if (is_callable($this->exceptionListener)) {
                call_user_func($this->exceptionListener, $e, $sqlStr);
            } else {
                throw $e;
            }
        }
        return 0;
    }

    /**
     * @return callable
     */
    public function getExceptionListener()
    {
        return $this->exceptionListener;
    }

    /**
     * @param callable $exceptionListener
     */
    public function setExceptionListener($exceptionListener)
    {
        $this->exceptionListener = $exceptionListener;
    }
}