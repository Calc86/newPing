<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 10.06.14
 * Time: 10:28
 * записывает результаты теста в файлы
 */

namespace ping;


class stateRule extends Rule {
    const DIR = 'state';

    private $status = Result::UNKNOWN;
    private $time;

    public function __construct(Test $test)
    {
        parent::__construct($test);

        if(file_exists($this->getFile())){
            $cvs = file_get_contents($this->getFile());
            list($host, $test, $status, $time) = str_getcsv($cvs,';');
            $this->status = $status;
        }
        if(!is_dir($this->getPath()))
            mkdir($this->getPath(), 0777, true);

        $this->time = time();
    }

    private function getFile(){
        return str_replace(array('(',')'), array('_',''), $this->getPath().'/'.$this->getTestName());
    }

    private function getPath(){
        return stateRule::DIR.'/'.$this->getHostName();
    }

    public function execute()
    {
        if($this->getResultStatus() != $this->status){
            $this->time = time();
            $this->status = $this->getResultStatus();

            $csv = array(
                $this->getHostName(),
                $this->getTestName(),
                $this->getResultStatus(),
                $this->time
            );
            //Tester::getInstance()->addCommand(new fileCommand($this->getFile(), implode(';',$csv)));
            $command = new fileCommand($this->getFile(), implode(';',$csv));
            $command->execute();
        }
        else{
            //Tester::getInstance()->addCommand(new touchCommand($this->getFile()));
            $command = new touchCommand($this->getFile());
            $command->execute();
        }
    }
} 