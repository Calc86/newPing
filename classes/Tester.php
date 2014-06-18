<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 09.06.14
 * Time: 14:38
 */

namespace ping;


class Tester {
    private static $instance = null;

    /**
     * @var ICommand
     */
    private $commands = array();

    private function __construct()
    {
    }

    /**
     * @return Tester
     */
    public static function getInstance(){
        if(self::$instance == null) self::$instance = new static;
        return self::$instance;
    }

    public function test(array $hosts){
        //$hosts  = $ping->getHosts();
        $bathTests = array();
        $tests = array();


        foreach($hosts as $host){
            /** @var $host Host */
            $hostTests = $host->getTests();
            foreach($hostTests as $test){
                /** @var $test Test */
                $test->execute();
                $bathTests[$test->getName()] = $test;
                $tests[$test->getName()][] = $test;
            }
        }

        $result = array();
        foreach($bathTests as $name=>$bathTest){
            /** @var $bathTest Test */
            $result = $bathTest->bathExecute();
            if(count($result))
                foreach($tests[$name] as $test){
                    /** @var $test Test */
                    if(isset($result[$test->getHost()->getHost()])){
                        $test->setResult($test->createResult($result[$test->getHost()->getHost()]));
                    }
                    else{
                        echo '!!!'.$test->getHost()->getHost().'!!!';
                    }
                }

            //var_dump($result);
        }

        foreach($this->commands as $command){
            /** @var $command ICommand */
            $command->execute();
        }
    }

    public function addCommand(ICommand $command){
        $this->commands[] = $command;
    }
} 