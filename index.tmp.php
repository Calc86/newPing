<html>
    <head>
        <title>Ping-map</title>
        <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf8">
        <style type="text/css" media="all">
            @import url("./css/s.css");
            @import url("./css/smoothness/jquery-ui-1.8.1.custom.css");
        </style>
        <!--<script src="./js/jquery-1.4.2.js" type="text/javascript"></script>-->
        <script type="text/javascript" src="./js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="./js/jquery-ui-1.8.16.custom.min.js"></script>

        <script src="./js/jquery.timers-1.2.js" type="text/javascript"></script>
        <script src="./js/jquery.ui.core.js" type="text/javascript"></script>
        <script src="./js/jquery.ui.datepicker.js" type="text/javascript"></script>
        <script src="./js/i18n/jquery.ui.datepicker-ru.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                //{JQ}
                $("#timer").everyTime(1000, function(i) {
                    $(this).text((i % 10));
                    if((i % 10) == 0){
                        //ajah
                        $(this).text("reload");
                        $("#lamps").text("").load("./ajah/lamps.php");
                    }
                });

                //$("img.lamp").draggable({ delay: 500, grid: [5, 5] });
                $("img.lamp")
                    .draggable({ delay: 100})
                    .bind( "dragstop", function(event, ui) {
                        //if(!{STOP}) return;
                        a_x = {A_X};
                        a_y = {A_Y};
                        ip = $(this).attr('id');
                        pos = $(this).position();
                        x = (pos.left-a_x+8);
                        y = (pos.top-a_y+8);
                        //$("#xy").text("").text(id+'_'+x+';'+y);
                        link = "./ajah/setpos.php?ip="+ip+"&x="+x+"&y="+y;
                        $("#xy").load(link);
                        //alert(link);
                    });

                //$("myCanvas").click(function() {
                //    alert("click");
                //});
            });
        </script>
        <!--<meta http-equiv="refresh" content="300">-->
        <!--<script type="text/javascript" src="wz_jsgraphics.js"></script>-->

        <script type="text/javascript">
            //ниже сприпты - самый гемор этого файла, javascript для определения координат и для отображения подсказок
            //показать инфу по лампочке
            function show_info(id){
                var el= document.getElementById(id);
                //alert(el);
                el.style.visibility="visible";
            }

            //скрыть инфу по лампочке
            function hide_info(id){
                var el= document.getElementById(id);
                el.style.visibility="hidden";
            }

            // код, выводящий координаты текущего положения мыши
            function defPosition(event){
                var x = y = 0;
                if (document.attachEvent != null) { // Internet Explorer & Opera
                    x = window.event.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);
                    y = window.event.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
                }
                else if (!document.attachEvent && document.addEventListener) { // Gecko
                    x = event.clientX + window.scrollX;
                    y = event.clientY + window.scrollY;
                } else {
                    // Do nothing
                }
                return {x:x, y:y};
            }

            //координаты мыши
            var x = {X};
            var y = {Y};

            function OnLoad() {
                var c_x = 400;	//точка центра, так, на глаз, экранные координаты
                var c_y = 100;

                //переданные_координаты+виртуальный_ноль-координаты_центра
                window.scrollTo(x+a_x-c_x,y+a_y-c_y);
            }

            // Простая проверка
            // С помощью document.write выведем координаты прямо в окно браузера
            // Они будут обновлять при движении мыши
            var a_x = {A_X};
            var a_y = {A_Y};
            var inf = '{DATE}';	//' - данная ковычка для правильного отображения цвета в mc =)
            document.onmousemove = function(event) {
                var event = event || window.event;
                //document.body.innerHTML = "x = " + defPosition(event).x + ", y = " + defPosition(event).y;
                var el = document.getElementById("xy");
                el.innerHTML = "<font size=\"-2\">Информация на: <a target=\"_parent\" href=\"./\" alt=\"Сбросить\">" + inf + "</a><br> x = " + (defPosition(event).x-a_x) + ", y = " + (defPosition(event).y-a_y) + "</font>";
                if (document.attachEvent != null) { // Internet Explorer & Opera
                    el.style.left = (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);
                    el.style.top  = (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
                } else if (!document.attachEvent && document.addEventListener) { // Gecko
                    el.style.left = window.scrollX;
                    el.style.top  = window.scrollY;
                } else {
                    // Do nothing
                }

                //var add_ip = parent.frames[1].document.getElementById("add");
                //add_ip.innerHTML= "Добавить ip (" + (defPosition(event).x-65) + "," + (defPosition(event).y-44) +")"
                //add_ip.href="./add.php?xy=" + (defPosition(event).x-65) + "," + (defPosition(event).y-44);
            }

            // по клику меняет ссылку и название ссылки во фреме со статистикой
            document.onmousedown = function(event)
            {
                //alert("asd");
                //Если в документ index.php добавляем фреймы, ниже нужно менять индекс фрейма
                var add_ip = parent.frames[2].document.getElementById("add");	// add - ссылка в фрейме
                add_ip.innerHTML= "Добавить ip (" + (defPosition(event).x-a_x) + "," + (defPosition(event).y-a_y) +")"
                add_ip.href="./add.php?xy=" + (defPosition(event).x-a_x) + "," + (defPosition(event).y-a_y);
            }
        </script>
    </head>
<body leftmargin="0" topmargin="0" bootommargin="0" onload="OnLoad()">
<div id="lamps" style="position:relative;height:{H}px;width:{W}px;background-image: url(./map.png)">
    {BODY}
</div>
    {PANEL}
<div id="timer"></div>
</body>
</html>
