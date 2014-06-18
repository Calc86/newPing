<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 09.06.14
 * Time: 15:05
 */

namespace ping;


class Bash {
    private $bash = '';

    function __construct($bash)
    {
        $this->bash = $bash;
    }

    public function exec(){
        return Bash::execute($this->bash);
    }

    public static function execute($bash){
        $output = array();

        exec($bash, $output);

        return $output;
    }
} 