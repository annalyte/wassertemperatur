<?php 
setlocale (LC_TIME, 'de_DE');



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
<title>Wasser</title>

<meta charset="utf-8">

<!-- iOS Dinge -->
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name="viewport" content="width = 480px, inital-scale = 1.0, user-scalable=no"> 
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<link rel="apple-touch-icon" href="<?php echo $directory; ?>/apple-touch-icon.png"/>

<!-- RSS Database.xml integration (XML ist nicht valide, funktioniert deshalb nicht) -->
<link rel="alternate" type="application/rss+xml" title="Wassertemperatur" href="<?php echo $directory; ?>/database.xml" />

<!-- Auto Reload -->
<meta http-equiv="refresh" content="300" >

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $directory; ?>jquery.countdown.js"></script>
<script type="text/javascript">
$(function () {
    var openingDay = new Date(2014, 05-1, 24, 10);
    $('#defaultCountdown').countdown({until: openingDay});
});
</script>



<style type="text/css">
<?php
// Alles was mit dem Aussehen zu tun hat
require('appearance.php');
?>
</style>

</head>
<body>


<?php
// Sieht nach ob wir uns in der Saison befinden oder nicht. Wenn nicht wird das Script per exit beendet. (das Ende des Scripts ganz unten beachten!)
if($end_time < $cur_time) {
    require('winter_time.php');
    exit();
} else { ?>
<div id="wrap">        
                <div id="layer">
                <div id="status_bar"> <p class="date"><?php echo $data['site_date']; ?></p> <p class="time"><?php echo $data['site_time']; ?></p> </div> 
                    <h1 class="today"><?php echo $data['temperature']; ?>&deg;</h1>
                    <h2><?php echo $description; ?></h2>
                    <div id="the_past">
                    	<div class="past_entry">
                    		<div class="past_date">
                    		<?php $one_date = date_create($one_day_data['cur_timestamp']);
	                    		echo date_format($one_date, 'l')
	                    	?>  </div>
                    	
                    		<div class="past_temp">
                    			<?php echo $one_day_data['temperature']; ?>&deg;
                    		</div>
                    	</div>
                    	<div style="clear:both;"></div>
                    	<div class="past_entry">
                    		<div class="past_date">
                    		<?php $two_date = date_create($two_day_data['cur_timestamp']);
	                    		echo date_format($two_date, 'l')
	                    	?>  </div>
	                    	<div class="past_temp">
                    		<?php echo $two_day_data['temperature']; ?>&deg;
                    		</div>
                    	</div>
                    	<div style="clear:both;"></div>
                    	<div class="past_entry">
                    		<div class="past_date">
                    		<?php $three_date = date_create($three_day_data['cur_timestamp']);
	                    		echo date_format($three_date, 'l')
	                    	?>  </div>
	                    	<div class="past_temp">
                    		<?php echo $three_day_data['temperature']; ?>&deg;
                    		</div>
                    	</div> 
                    	
                    	
 
                    </div>
                    <?php echo '<p class="year_ago">Vor einem Jahr hatte das Wasser '.$year_ago_data['temperature'].' Grad.</p>'; ?>
                    <!-- Das exakte  Datum war: <?php echo $year_ago_data['cur_timestamp']; ?> -->
                 <!--   <p class="version"><?php echo $versioning; ?></p> -->
                 <!-- Twitter Integration -->
                 <p>
	                 <a href="https://twitter.com/wassertemp" class="twitter-follow-button" data-show-count="false" data-lang="de" data-show-screen-name="true" data-size="large">Follow @twitterapi</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                 </p>
                </div>
                
</div>
<!-- Core Process ran on <?php echo $data['cur_timestamp']; ?> -->
</body>
</html>
<?php }; ?>