<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 09.06.14
 * Time: 18:48
 */

namespace ping;


class fpingResult extends Result{
    protected function parseResult()
    {
        list($host, $is, $status) = explode(' ', $this->getString());
        if($status == 'alive') $this->setStatus(Result::LIVE);
        else $this->setStatus(Result::DEAD);
    }
}