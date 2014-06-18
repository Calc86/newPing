<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 09.06.14
 * Time: 14:39
 */

namespace ping;


abstract class Test {

    /**
     * @var Host
     */
    private $host;

    /**
     * @var Result
     */
    private $result;

    /**
     * @var string
     */
    protected  $name;

    private $rules = array();

    function __construct(Host $host, $name, array $params){
        $this->host = $host;
        $this->name = $name;
    }

    abstract public function execute();

    /**
     * @return array
     */
    public function bathExecute(){
        return array();
    }

    /**
     * @param Result $result
     */
    public function setResult(Result $result){
        $this->result = $result;
        $this->executeRules();
    }

    protected function executeRules(){
        foreach($this->rules as $rule){
            /** @var $rule Rule */
            $rule->execute();
        }
    }

    /**
     * @param $string
     * @return mixed
     */
    abstract public function createResult($string);

    public function getName(){
        return $this->name;
    }

    public function getHost(){
        return $this->host;
    }

    public function getResult(){
        return $this->result;
    }

    public function addRule(Rule $rule){
        $this->rules[] = $rule;
    }
} 