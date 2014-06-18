<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 10.06.14
 * Time: 11:57
 */

namespace ping;


class Web {
    const CENTER_X = 1130;
    const CENTER_Y = 904;

    public static function getVar($var, $default = ''){
        return isset($_GET[$var]) ? $_GET[$var] : $default;
    }

    public function getNames(){
        $q = "select ip, name from ips where hide=0";
        $r = Database::getInstance()->query($q);

        $names = array();

        while( ($row = $r->fetch_row()) != false){
            list($host, $name) = $row;

            $names[$host] = $name;
        }

        return $names;
    }

    public function getComments(){
        $q = "select ip, comment from ips where hide=0";
        $r = Database::getInstance()->query($q);

        $comments = array();

        while( ($row = $r->fetch_row()) != false){
            list($host, $comment) = $row;

            $comments[$host] = $comment;
        }

        return $comments;
    }

    public function lamps(){

        $q = "select ip, x, y from ips where hide=0";
        $r = Database::getInstance()->query($q);

        $xs = array();
        $ys = array();

        $names = $this->getNames();
        $comments = $this->getComments();

        while( ($row = $r->fetch_row()) != false){
            list($host, $x, $y) = $row;

            $xs[$host] = $x-7 + Web::CENTER_X;
            $ys[$host] = $y-7 + Web::CENTER_Y;
        }

        $array = json_decode($this->get('','fping'));

        $body = '';
        foreach($array as $host=>$values){
            $x = $xs[$host];
            $y = $ys[$host];

            foreach($values as $test=>$params){

                $body.= $this->lamp($host, $names[$host], $comments[$host] , $params[2], $x, $y);
            }
        }

        return $body;
    }

    public function lampImg($host, $status, $x, $y){
        if($status == Result::DEAD)
            return '<img id="img_'.$host.'" class="lamp" border="0" src="down.gif" style="LEFT: '.($x).'px; TOP: '.($y).'px;" onmousemove="show_info(\''.$host.'\')" onmouseout="hide_info(\''.$host.'\')">';
        if($status == Result::LIVE)
            return '<img id="img_'.$host.'" class="lamp" border="0" src="up.gif" style="LEFT: '.($x).'px; TOP: '.($y).'px;" onmousemove="show_info(\''.$host.'\')" onmouseout="hide_info(\''.$host.'\')">';
        return '<img id="img_'.$host.'" class="lamp" border="0" src="gray.gif" style="LEFT: '.($x).'px; TOP: '.($y).'px;" onmousemove="show_info(\''.$host.'\')" onmouseout="hide_info(\''.$host.'\')">';
    }

    public function lamp($host, $name, $comment, $status, $x, $y){
        $ret = '';
        $ret.= "<a target='_parent' href='./add.php?id=$host'>".$this->lampImg($host, $status, $x, $y)."</a>";

        $ret.= '<div class="info" style="LEFT: '.($x+16).'px; TOP: '.($y+16).'px;" id="'.$host.'">';
        $ret.= '<table width="150">';
        $ret.= '<tr>'.'<th colspan="2">'.$name.'</th>'.'</tr>';
        $ret.= '<tr><td><b>ip:</b></td><td align="center">'.$host.'</td></tr>';
        $ret.= '<tr>';
        $ret.= '<td colspan="2" align="center">';
        $ret.= '<font size="-2">'.$comment.'</font>';
        $ret.= '</td>';
        $ret.= '</tr>';
        $ret.= '</table>';
        $ret.= '</div>';

        return $ret;
    }

    public function get($needStatus = '', $needTest = ''){

        $json = array();

        $q = "select ip from ips where hide=0";
        $r = Database::getInstance()->query($q);

        $path = realpath($_SERVER['DOCUMENT_ROOT'].'/state');
        while(($row = $r->fetch_row()) != false){
            list($host) = $row;

            //$json[$host] = array();
            $hostPath = $path.'/'.$host;
            if(is_dir($hostPath)){
                $d2 = dir($hostPath);
                /** @var $d \Directory */
                while (false !== ($test = $d2->read())) {
                    //if($entry == '.' || $entry == '..') continue;
                    if(!is_file($hostPath.'/'.$test)) continue;

                    //берем только файлы за последние 2 минуты
                    if(filectime($hostPath.'/'.$test) < time()-120) continue;

                    $buf = file_get_contents($hostPath.'/'.$test);
                    $csv = str_getcsv($buf, ';');
                    list($ip, $t, $status, $time) = $csv;
                    if(($status == $needStatus || $needStatus == '') && ($t == $needTest || $needTest == ''))
                        $json[$host][$test] = $csv;
                }
                $d2->close();
            }
            //if(!count($json[$host]))
            if(!isset($json[$host]) && $needStatus == "")
            {
                $json[$host] = array('unknown');
            }
        }

        return json_encode($json);
        //return $json;
    }
}
