<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 10.06.14
 * Time: 14:05
 */

require_once __DIR__.'/../interfaces/include.php';
require_once __DIR__.'/../classes/include.php';

$web = new \ping\Web();

echo $web->lamps();
