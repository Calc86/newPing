<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 09.06.14
 * Time: 14:36
 */

namespace ping;


class Ping {
    private $tester;
    private $hosts = array();

    function __construct(array $hosts, $default, $defaultRules)
    {
        foreach($hosts as $host => $tests){
            $h = new Host($host);
            array_unshift($tests, $default);
            foreach($tests as $params){
                $name = $params[0];
                $class = "ping\\".$name."Test";
                $test = new $class($h, $params[1]);
                /** @var $test Test */

                $params[2] = array_merge($defaultRules, $params[2]);
                foreach($params[2] as $rule){
                    $class = "ping\\".$rule."Rule";
                    $test->addRule(new $class($test));
                }
                $h->addTest($test);
            }

            $this->hosts[] = $h;
        }

        $this->tester = Tester::getInstance();
    }

    public function getHosts(){
        return $this->hosts;
    }
}