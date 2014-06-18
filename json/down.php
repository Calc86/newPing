<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 10.06.14
 * Time: 11:56
 */

require_once __DIR__.'/../interfaces/include.php';
require_once __DIR__.'/../classes/include.php';

$web = new \ping\Web();

$names = array();

$q = "select ip,name from ips where hide=0";
$r = \ping\Database::getInstance()->query($q);

while( ($row = $r->fetch_row()) != false){
    list($ip, $name) = $row;
    $names[$ip] = $name;
}

echo $web->get(\ping\Result::DEAD);
