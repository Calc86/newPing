<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 10.06.14
 * Time: 13:43
 */

namespace ping;


class Lock {
    private $path;
    private $fName;

    const EXTENSION = '.lock';

    /**
     * @param string $fName filename/function name/ __FUNCTION__
     */
    function __construct($fName)
    {

        $this->fName = $fName.Lock::EXTENSION;

        $this->path = $this->fName;
    }

    /**
     * @return bool
     */
    public function create(){
        if(file_exists($this->path)){
            return false;
        }
        $f = fopen($this->path, "w+");
        fclose($f);
        return true;
    }

    /**
     *
     */
    public function delete(){
        if(file_exists($this->path))
            unlink($this->path);
    }

    /**
     * @param $maxTimeout
     * @return bool seconds
     */
    public function wait($maxTimeout){
        $wait = 0;
        while(1){
            if(file_exists($this->path)){
                sleep(1); $wait ++;
            }
            else
                return true;
            if($wait > $maxTimeout)
                return false;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
