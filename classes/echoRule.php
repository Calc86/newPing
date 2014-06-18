<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 10.06.14
 * Time: 5:51
 */

namespace ping;


class echoRule extends Rule {
    public function execute()
    {
        $host = $this->getHostName();
        $name = $this->getTestName();
        $result = $this->getResultStatus();
        echo "$host:$name:$result\n";
    }
} 