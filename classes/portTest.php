<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 10.06.14
 * Time: 6:16
 */

namespace ping;


class portTest extends Test {
    private $port = 0;

    function __construct(Host $host, array $params)
    {
        parent::__construct($host, 'port', $params);
        $this->port = $params[0];
    }

    /**
     * @param $string
     * @return mixed
     */
    public function createResult($string)
    {
        return new portResult($string);
    }

    public function getName()
    {
        return parent::getName()."($this->port)";
    }

    public function execute()
    {
        $result = Result::UNKNOWN;
        try{
            $errno = 0;
            $errstr = '';
            $f = fsockopen($this->getHost()->getHost(), $this->port, $errno, $errstr, 0.2);
            $result = Result::LIVE;
            fclose($f);
        }catch (\Exception $e){
            $result = Result::DEAD;
        }
        $this->setResult(new portResult($result));

    }


} 