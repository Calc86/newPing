<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 09.06.14
 * Time: 14:36
 */

namespace ping;


class Host {
    /**
     * @var string ip or host
     */
    private $host;

    /**
     * @var HostMap
     */
    private $hostMap;

    /**
     * @var array of Test
     */
    private $tests = array();

    function __construct($host)
    {
        $this->host = $host;
    }

    public function addTest(Test $test){
        $this->tests[] = $test;
    }

    public function getTests(){
        return $this->tests;
    }

    public function getHost(){
        return $this->host;
    }
}
