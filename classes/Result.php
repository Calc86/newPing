<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 09.06.14
 * Time: 14:39
 */

namespace ping;


abstract class Result {
    const LIVE = 'live';
    const DEAD = 'dead';
    const UNKNOWN = 'unknown';

    private $string;

    private $status = Result::UNKNOWN;

    function __construct($string)
    {
        $this->string = $string;
        $this->parseResult();
    }

    abstract protected function parseResult();

    protected function getString(){
        return $this->string;
    }

    /**
     * @param string $status
     */
    protected function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }


}