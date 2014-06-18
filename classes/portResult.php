<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 10.06.14
 * Time: 6:17
 */

namespace ping;


class portResult extends Result {
    protected function parseResult()
    {
        $this->setStatus($this->getString());
    }
} 