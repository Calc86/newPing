<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 10.06.14
 * Time: 11:35
 */

namespace ping;


class Database {
    /**
     * @var \mysqli
     */
    private $db;
    private static $instance = null;

    /**
     *
     */
    private function __construct(){
        $this->db = $this->openDB('127.0.0.1', 'c1ping', '12345', 'c1ping');
    }

    private function openDB($h,$u,$p,$n,$utf=1) {
        $db = new \mysqli($h,$u,$p,$n);
        if($utf){
            if(!$db->query("SET character_set_client='utf8'")) throw new MysqlQueryException();
            if(!$db->query("SET character_set_connection='utf8'")) throw new MysqlQueryException();
            if(!$db->query("SET character_set_results='utf8'")) throw new MysqlQueryException();
        }

        return $db;
    }

    private function __clone()
    {
    }

    /**
     * @return Database
     */
    public static function getInstance(){
        if(self::$instance === null) self::$instance = new self();
        return self::$instance;
    }

    /**
     * @return \mysqli
     */
    public function getDB(){
        return $this->db;
    }

    /**
     * @param $query
     * @return \mysqli_result
     * @throws MysqlQueryException
     */
    public function query($query){
        $r = $this->db->query($query);
        if(!$r) throw new MysqlQueryException($query."; ".$this->db->error);
        return $r;
    }
}

class MysqlQueryException extends \Exception{}
