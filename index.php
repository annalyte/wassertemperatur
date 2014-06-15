<?php 

setlocale (LC_ALL, 'de_DE');


error_reporting(0); // Keine PHP Fehlermeldungen


//Frontend mit den MSQL Abfragen und der Winteranzeige
require('frontend.php'); 

/*
$directory = Ort der im frontend angegeben wurde
$data =  Array mit den Daten von heute
$previous_data = Array mit den Daten von gestern
$description = Beschreibung der Temperatur
$color = Farbe die zur Temperatur passt
$comparison = Vergleichstext zwischen gestern und heute
$versioning = Versionierungsschema fŸr ganz unten
$end_time und $cur_time sind die Zeitstempel
*/
?>
<!DOCTYPE HTML>
<html>
<head>



<title>Wasserw&auml;rme | Das Wasser hat <?php echo $data['temperature']; ?> Grad</title>

<meta charset="utf-8">

<!-- Das hilft Google -->
<meta name="keywords" content="wasserwaerme, wasserw&auml;rme, wassertemperatur, fischach, naturfreibad" />
<meta name="description" content="Wasserwaer.me ist eine praktische App, die Ihnen die Wassertemperatur im Naturfreibad Fischach übersichtlich anzeigt." />

<!-- iOS Dinge -->
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name="viewport" content="user-scalable=0, initial-scale=1.0" /> 
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<link rel="apple-touch-icon" href="<?php echo $directory; ?>apple-touch-icon.png"/>


<!-- iPhone 4 (Retina) -->
<link href="<?php echo $directory; ?>image_store/apple-touch-startup-image-640x920.png" 
      media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)" 
      rel="apple-touch-startup-image">
<!-- iPhone 5 -->
<link href="<?php echo $directory; ?>image_store/apple-touch-startup-image-640x1096.png" 
      media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" 
      rel="apple-touch-startup-image">

<!-- RSS Database.xml integration (XML ist nicht valide, funktioniert deshalb nicht) -->
<link rel="alternate" type="application/rss+xml" title="Wassertemperatur" href="<?php echo $directory; ?>database.xml" />

<!-- Auto Reload -->
<meta http-equiv="refresh" content="300" >

<!-- Fav Icon -->
<link rel="icon" type="image/png" href="apple-touch-icon-precomposed.png" />

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo $directory; ?>jquery.plugin.js"></script>
<script src="<?php echo $directory; ?>jquery.countdown.js"></script>
<script type="text/javascript">
$(function () {
    var openingDay = new Date(2014, 5 - 1, 24, 8);
    $('#defaultCountdown').countdown({until: openingDay});
});
</script>

<!-- Google Tracker -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-51202326-1', 'wasserwaer.me');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');

</script>




<style type="text/css">
<?php
// Alles was mit dem Aussehen zu tun hat
require('appearance.php');
?>
</style>

</head>
<body>

<div class="background_image_container"></div>
<div id="status_bar"></div>
<?php
// Sieht nach ob wir uns in der Saison befinden oder nicht. Wenn nicht wird das Script per exit beendet. (das Ende des Scripts ganz unten beachten!)
if($end_time > $cur_time) {
    require('winter_time.php');
    exit();
} else { ?>

<div id="wrap">                   
                    <h1 class="today"><?php echo $data['temperature']; ?></h1>                 
                    <div id="passed_time"><?php echo $time_diff; ?></div>
                    <div id="the_past">
                    	<div class="past_entry">
                    		<div class="past_date">
                    		<?php echo strftime("%A", strtotime($one_day_data['cur_timestamp'])); ?> 
                    		</div>
                    	
                    		<div class="past_temp">
                    			<?php echo $one_day_data['temperature']; ?>
                    		</div>
                    	</div>
                    	<div style="clear:both;"></div>
                    	<div class="past_entry">
                    		<div class="past_date">
                    		<?php echo strftime("%A", strtotime($two_day_data['cur_timestamp'])); ?>  
                    		</div>
	                    	<div class="past_temp">
                    		<?php echo $two_day_data['temperature']; ?>
                    		</div>
                    	</div>
                    	<div style="clear:both;"></div>
                    	<div class="past_entry">
                    		<div class="past_date">
                    		<?php echo strftime("%A", strtotime($three_day_data['cur_timestamp'])); ?> 
                    		</div>
	                    	<div class="past_temp">
                    		<?php echo $three_day_data['temperature']; ?>
                    		</div>
                    	</div> 
                    	
                    	
 
                    </div>
                    <?php echo '<p class="year_ago">Vor einem Jahr hatte das Wasser '.$year_ago_data['temperature'].' Grad.</p>'; ?>
                    <!-- Das exakte  Datum war: <?php echo $year_ago_data['cur_timestamp']; ?> -->
                 <!--   <p class="version"><?php echo $versioning; ?></p> -->
                 <!-- Twitter Integration -->
                 <!--
                 <p>
	                 <a href="https://twitter.com/wassertemp" class="twitter-follow-button" data-show-count="false" data-lang="de" data-show-screen-name="true" data-size="large">Follow @twitterapi</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                 </p> -->      
</div>
<!-- Core Process ran on <?php echo $data['cur_timestamp']; ?> -->

<!--
<video id="videobcg" preload="auto" autoplay="true" loop="loop" muted="muted" volume="0">
     <source src="image_store/video.mp4" type="video/mp4">
     
          Sorry, your browser does not support HTML5 video.
</video>
-->
</body>
</html>
<?php }; ?>