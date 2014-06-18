<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 09.06.14
 * Time: 14:47
 */

require_once __DIR__.'/interfaces/include.php';
require_once __DIR__.'/classes/include.php';

function handleError($err_no, $err_str, $err_file, $err_line, array $err_context)
{
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }

    throw new Exception($err_str);
}
set_error_handler('handleError', E_ALL);

$defaultRules = array('echo', 'post', 'state');
$default = array('fping', array(), $defaultRules);

if(file_exists('hosts'))
    unlink('hosts');
$q = "select ip from ips where hide = 0";
$r = \ping\Database::getInstance()->query($q);
while(($row = $r->fetch_array()) != false){
    list($ip) = $row;
    \ping\Bash::execute("echo $ip >>hosts");
}

$buf = file_get_contents('hosts');
$hosts = explode("\n", $buf);

$hosts1 = array();
foreach($hosts as $host){
    $host = trim($host);
    if($host == '') continue;
    $hosts1[$host] = array();
}
unset($hosts);

$hosts2 = array(
    '10.112.10.5' => array(
        array('port', array(80),   array()),
    ),
    '127.0.0.1' => array(
        //array('port', array(8006),   array()),
        array('port', array(443),   array()),
        array('port', array(80),   array()),
        array('port', array(8080),   array()),
        //array('port', array(2222),   array()),
    ),
    '10.112.0.85' => array(
        array('port', array(443),   array()),
    ),
);

foreach($hosts2 as $host=>$array){
    $hosts1[$host] = $array;
}

//print_r($hosts1);
//exit();
$ping = new ping\Ping($hosts1, $default, $defaultRules);

$tester = ping\Tester::getInstance();
$lock = new \ping\Lock('test');

if(!$lock->create()){
    // вдруг система перезагрузилась во время update
    $lock->wait(5*60);
    $lock->delete();
    $lock->create();
}

$tester->test($ping->getHosts());

$lock->delete();

//print_r($ping);
