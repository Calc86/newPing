<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 10.06.14
 * Time: 18:09
 */

namespace ping;


class touchCommand implements ICommand {
    //private $file;

    function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * @return void
     */
    public function execute()
    {
        touch($this->file, time(), time());
    }
}