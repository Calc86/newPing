<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 09.06.14
 * Time: 14:39
 */

namespace ping;


abstract class Rule {
    /**
     * @var Test
     */
    private $test;

    public function __construct(Test $test)
    {
        $this->test = $test;
    }

    /**
     * @return \ping\Test
     */
    protected function getTest()
    {
        return $this->test;
    }

    protected function getHostName(){
        return $this->getTest()->getHost()->getHost();
    }

    protected function getTestName(){
        return $this->getTest()->getName();
    }

    protected function getResultStatus(){
        return $this->getTest()->getResult()->getStatus();
    }

    abstract public function execute();
}
