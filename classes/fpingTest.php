<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 09.06.14
 * Time: 14:47
 */

namespace ping;


class fpingTest extends Test {
    private static $hosts = array();

    function __construct(Host $host, array $params)
    {
        parent::__construct($host, 'fping', $params);
    }

    public function execute()
    {
        $host = $this->getHost()->getHost();
        fpingTest::$hosts[] = $host;
    }

    /**
     * возвращает ассоциативный массив с ключем по имени хоста
     * @return array
     */
    public function bathExecute()
    {
        $file = '';
        if(file_exists("fping")){
            unlink('fping');
        }
        foreach(self::$hosts as $host){
            Bash::execute("echo $host >> fping");
        }
        $lines = Bash::execute("/usr/sbin/fping < fping");

        $result = array();
        foreach($lines as $line){
            list($host) = explode(" ", $line);
            $result[$host] = $line;
        }
        return $result;
    }

    /**
     * @param $string
     * @return Result
     */
    public function createResult($string)
    {
        return new fpingResult($string);
    }


}
