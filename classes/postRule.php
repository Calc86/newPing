<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 10.06.14
 * Time: 7:04
 */

namespace ping;

class echoCommand implements ICommand{
    private $text = "";

    function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * @return void
     */
    public function execute()
    {
        echo $this->text."\n";
    }
}

class postRule extends Rule{
    public function execute()
    {
        if($this->getTest()->getResult()->getStatus() != Result::LIVE){
            $host = $this->getHostName();
            $name = $this->getTestName();
            $result = $this->getResultStatus();
            Tester::getInstance()->addCommand(new echoCommand("$host:$name:$result"));
        }
    }

} 