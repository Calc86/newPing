<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 10.06.14
 * Time: 11:56
 */

require_once __DIR__.'/interfaces/include.php';
require_once __DIR__.'/classes/include.php';

$web = new \ping\Web();

$names = array();

$q = "select ip,name from ips where hide=0";
$r = \ping\Database::getInstance()->query($q);

while( ($row = $r->fetch_row()) != false){
    list($ip, $name) = $row;
    $names[$ip] = $name;
}

?>

<html>
    <head>
        <title>Ping - down</title>
        <script type="text/javascript" src="./js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="./js/jquery-ui-1.8.16.custom.min.js"></script>

        <script src="./js/jquery.timers-1.2.js" type="text/javascript"></script>
        <script src="./js/jquery.ui.core.js" type="text/javascript"></script>
        <script src="./js/jquery.ui.datepicker.js" type="text/javascript"></script>
        <script src="./js/i18n/jquery.ui.datepicker-ru.js" type="text/javascript"></script>

        <script type="text/javascript">
            $(document).ready(function() {

                $("body").everyTime(10000, function(i) {
                    location.reload();
                });
            });
        </script>
        <style>
            table{
                width: 100%;
                background-color: wheat;
            }

            .host, .name{
                width: 50%;
                border-top: solid 1px olivedrab;
            }


        </style>
    </head>
    <body>
        <table>

<?php
    $array = json_decode($web->get(\ping\Result::DEAD));
    foreach($array as $host=>$values){
        echo '<tr>';
        echo '<td class="host">';
        echo $host;
        echo '</td>';
        echo '<td class="name">';
        echo $names[$host];
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan="2">';
        echo '<table>';
        foreach($values as $test=>$params){
            echo '<tr>';
            if(isset($params[3])){
                echo "<td class=\"time\" width='50%'>".date("Y-m-d H:i:s",$params[3])."</td>";
            }
            echo "<td class=\"test\" width='30%'>$test</td>";
            if(isset($params[2])){
                echo "<td class=\"status\">$params[2]</td>";
            }
            echo '</tr>';
        }
        echo '</table>';
        echo '</td>';
        echo '</tr>';
    }
?>
        </table>
    </body>
</html>
