<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 10.06.14
 * Time: 12:42
 */

require_once __DIR__.'/interfaces/include.php';
require_once __DIR__.'/classes/include.php';

header("Content-Type: text/html; charset=utf-8");

//виртуальные нулевые координаты (метка на карте)
// 2011_10_21
//$a_x = 715+400; //-400 - отображаемая зона по умолчанию
//$a_y = 44;
$a_x = 1130; //-400 - отображаемая зона по умолчанию
$a_y = 450;

$x = \ping\Web::getVar('x', 0);
$y = \ping\Web::getVar('y', 0);
$web = new \ping\Web();
$body = $web->lamps();

$html = file_get_contents("./index.tmp.php");
$html = str_replace("{X}", $x,$html);
$html = str_replace("{Y}", $y,$html);
$html = str_replace("{A_X}", $a_x,$html);
$html = str_replace("{A_Y}", $a_y,$html);
$html = str_replace("{W}", 3284,$html);
$html = str_replace("{H}", 3159,$html);
//$html = str_replace("{DATE}", date("Y-m-d H:i:s",$time),$html);
$html = str_replace("{BODY}", $body,$html);
$html = str_replace("{PANEL}", panel_info(),$html);
echo $html;

function panel_info() {
    $ret = '';
    $ret.= '<!-- Панелька с датой и координатами -->'."\n";
    $ret.= '<div style="width: 170px; BORDER-RIGHT: #000000 1px solid; BORDER-TOP: #000000 1px solid; LEFT: 0px; BORDER-LEFT: #000000 1px solid; BORDER-BOTTOM: #000000 1px solid; POSITION: absolute; TOP: 0px; Z-INDEX: 100; BACKGROUND-COLOR: gainsboro" id="xy">'."\n";
    $ret.= '</div>'."\n";
    return $ret;
}
