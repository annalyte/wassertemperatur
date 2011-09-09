<?php 
require('frontend.php'); 
/*
$directory = Ort der im frontend angegeben wurde
$data =  Array mit den Daten von heute
$previous_data = Array mit den Daten von gestern
$description = Beschreibung der Temperatur
$color = Farbe die zur Temperatur passt
$comparison = Vergleichstext zwischen gestern und heute
$versioning = Versionierungsschema für ganz unten
*/
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