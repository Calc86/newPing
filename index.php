<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 10.06.14
 * Time: 10:56
 */
?>

<FRAMESET FRAMEBORDER="0" FRAMESPACING="0" BORDER="0" COLS="*,320">
    <FRAMESET FRAMEBORDER="0" FRAMESPACING="0" BORDER="0" ROWS="*,22">
        <FRAME SRC="./map.php" NAME="map">
        <FRAME SRC="./menu.php" NAME="menu">
    </FRAMESET>
    <FRAME SRC="./down.php?r=<? echo rand();?>" NAME="menu1" id="fr_st" MARGINWIDTH="0">
    <NOFRAMES>Ваш браузер не поддерживает фреймы</NOFRAMES>
</FRAMESET>