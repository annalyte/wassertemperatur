<?php
/*
Freibad Wassertemperatur
Datum: 04.09.2011
Setzt voraus, dass das daemon.php stündlich ausgeführt wird.
Setzt voraus, dass database.xml und scrape.txt mit Schreibrechten versehen sind
*/

$version = '0.8.1';
$build = '8c4e99';

$versioning = 'Version: '.$version.' ('.$build.')'; 

// Hier den Ort eintragen
$directory = 'http://wasser.aaronbauer.org/';

// Verbindungsdaten zur MySQL Datenbank stehen in mysql.php in der Variable $link
require('mysql.php');

if(!$link) {
    die('Keine Verbindung: '.mysql_error());
};

// Auswählen der Datenbank
$db_selected = mysql_select_db('d011c151', $link);

if(!$db_selected) {
    die ('Kann Datenbank nicht nutzen: ' .mysql_error());
} else {
     
    // Holt die aktuelle Wassertemperatur  
    $query = 'SELECT * FROM wasser ORDER BY id DESC';
    $result = mysql_query($query) or die(mysql_error());
    
    $data = mysql_fetch_array($result) or die(mysql_error());
    
    // Holt die Temperatur vom Vortag, in dem der letzte Eintrag der nicht dem aktuellen Datum entspricht ausgegeben wird
    $previous_query = 'SELECT * FROM wasser
WHERE site_date <> "'.$data['site_date'].'" ORDER BY id DESC';

    $previous_data_result = mysql_query($previous_query) or die(mysql_error());
    
    $previous_data = mysql_fetch_array($previous_data_result) or die(mysql_error());
    
    mysql_close($link);
};

/* 
Wichtige SQL Syntax
INSERT INTO wasser (site_time, temperature) VALUES('18:00', '25');
SELECT * FROM 'wasser'
*/


// Beschreibung für die aktuelle Temperatur
if($data['temperature'] == '--') {
    echo 'Keine Daten.';
} else {
    switch ($data['temperature']) {
    case 26:
        $description = 'Viel zu warm!';
        $color = '#ff0033';
        break;
    case 25:
        $description = 'Sehr warm!';
        $color = '#ff3000';
        break;
    case 24:
        $description = 'Warm!';
        $color = '#ff3000';
        break;
    case 23:
        $description = 'Warm genug';
        $color = '#ff5202';
        break;
    case 22:
        $description = 'Angenehm';
        $color = '#ffa600';
        break;
    case 21:
        $description = 'Noch okay';
        $color = '#ffdd00';
        break;
    case 20:
        $description = 'Etwas k&uuml;hl';
        $color = '#dfff00';
        break;
    case 19:
        $description = 'Kalt';
        $color = '#00c3ff';
        break;
    case 18:
        $description = 'Zu Kalt';
        $color = '#00c3ff';
        break;        
};
};

if($previous_data['temperature'] == '--') {
    echo 'Keine Daten.';
} else {
// Beschreibung für die Temperatur vom Vortag
switch ($previous_data['temperature']) {
    case 26:
        $previous_description = 'Viel zu warm!';
        $previous_color = '#ff0033';
        break;
    case 25:
        $previous_description = 'Sehr warm!';
        $previous_color = '#ff3000';
        break;
    case 24:
        $previous_description = 'Warm!';
        $previous_color = '#ff3000';
        break;
    case 23:
        $previous_description = 'Warm genug';
        $previous_color = '#ff5202';
        break;
    case 22:
        $previous_description = 'Angenehm';
        $previous_color = '#ffa600';
        break;
    case 21:
        $previous_description = 'Noch okay';
        $previous_color = '#ffdd00';
        break;
    case 20:
        $previous_description = 'Etwas k&uuml;hl';
        $previous_color = '#dfff00';
        break;
    case 19:
        $previous_description = 'Kalt';
        $previous_color = '#00c3ff';
        break;
    case 18:
        $previous_description = 'Zu Kalt';
        $previous_color = '#00c3ff';
        break;  
}; 
};
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Wasser</title>

<!-- iOS Dinge -->
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name="viewport" content="width = device-width, user-scalable=no">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="apple-touch-icon" href="<?php echo $directory; ?>/apple-touch-icon.png"/>
<link rel="apple-touch-startup-image" href="<?php echo $directory; ?>/startup.png">

<!-- Google Font -->
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>

<!-- RSS Database.xml integration -->
<link rel="alternate" type="application/rss+xml" title="Wassertemperatur" href="<?php echo $directory; ?>/database.xml" />

<!-- iPad Stylesheet -->
<link rel="stylesheet" media="only screen and (min-device-width: 768px)
and (max-device-width: 1024px)" href="<?php echo $directory; ?>/ipad.css" type="text/css" />

<!-- iPhone Stylesheet -->
<link rel="stylesheet" media="only screen and (min-device-width: 320px)
and (max-device-width: 460px)" href="<?php echo $directory; ?>/iphone.css" type="text/css" />

<!-- Computer Stylesheet -->
<link rel="stylesheet" media="only screen and (min-device-width: 1025px)" href="<?php echo $directory; ?>/standard.css" type="text/css" />

<!-- jQuery -->
<script type="text/javascript" src="<?php echo $directory; ?>/jquery-1.6.2.js"></script>

<!-- Tolles Touch script von hier: http://james.lin.net.nz/2010/09/27/javascript-swipe-demo-works-both-with-finger-ipad-and-mouse-pc/ -->
<script type="text/javascript">// <![CDATA[
var $j = jQuery.noConflict();
var down_x = null;
var up_x = null;
$j().ready(function(){
  $j("#slider > div").mousedown(function(e){
    e.preventDefault();
    down_x = e.pageX;
  });
  $j("#slider > div").mouseup(function(e){
    up_x = e.pageX;
    do_work();
  });
  $j("#slider > div").bind('touchstart', function(e){
    down_x = e.originalEvent.touches[0].pageX;
  });
  $j("#slider > div").bind('touchmove', function(e){
    e.preventDefault();
    up_x = e.originalEvent.touches[0].pageX;
  });
  $j("#slider > div").bind('touchend', function(e){
    do_work();
  });
});
function do_work()
{
  if ((down_x - up_x) > 50)
    {
        slide_right();
    }
    if ((up_x - down_x) > 50)
    {
        slide_left();
    }
}
function slide_right()
{
  $j("#slider_content").animate({scrollLeft:'+=320'},1000);
}
function slide_left()
{
  $j("#slider_content").animate({scrollLeft:'-=320'},1000);
}
// ]]></script>



<style type="text/css">
h1.today {
    font-size: 65pt;
    padding:50px 0px 0px 0px;
    opacity: 0.9;
    margin:0;
    color:<?php echo $color; ?>;
    -webkit-mask-image: -webkit-gradient(linear, left top,
    left bottom, from(rgba(0,0,0,0.1)), to(rgba(0,0,0,1))); 
}

h1.yesterday {
    font-size: 65pt;
    padding:50px 0px 0px 0px;
    opacity: 0.9;
    margin:0;
    color:<?php echo $previous_color; ?>;
    -webkit-mask-image: -webkit-gradient(linear, left top,
    left bottom, from(rgba(0,0,0,0.1)), to(rgba(0,0,0,1)));
}

h2 {
    font-size: 20pt;
    opacity: 0.9;
}

p.version {
    font-size: 8pt;
    padding-top: 10px;
}

p{
    line-height: 21px;
    opacity: 0.9;
}
</style>

</head>
<body>
<div id="wrap">
    <div id="slider_content" style="width: 320px; height: 460px; overflow: hidden;">
        <div id="slider" style="height: 460px; width: 640px;">
        <!-- Temperatur von heute -->
            <div id="slide1" style="height: 460px; width: 320px; float:left;">
                <div class="layer">
                    <h1 class="today"><?php echo $data['temperature']; ?>&deg;C</h1>
                    <h2><?php echo $description; ?></h2>
                    <p>Gemessen am <b><?php echo $data['site_date']; ?></b> <br /> um <b><?php echo $data['site_time']; ?></b>.</p>
                    <p class="version"><?php echo $versioning; ?></p>
                </div>
            </div>
        <!-- /heute -->
        <!-- Temperatur von gestern -->
            <div id="slide2" style="height: 460px; width: 320px; float: left;">
                <div class="layer">
                    <h1 class="yesterday"><?php echo $previous_data['temperature']; ?>&deg;C</h1>
                    <h2><?php echo $previous_description; ?></h2>
                    <p>Gemessen am <b><?php echo $previous_data['site_date']; ?></b> <br /> um <b><?php echo $previous_data['site_time']; ?></b>.</p>
                </div>
            </div>
        <!-- /gestern -->
        </div>
    </div>
</div>
<!-- Daemon war zuletzt da: <?php echo $data['cur_timestamp']; ?> -->
</body>
</html>