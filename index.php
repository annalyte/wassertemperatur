<?php 

setlocale (LC_ALL, 'de_DE');


#error_reporting(0); // Keine PHP Fehlermeldungen


//Frontend mit den MSQL Abfragen und der Winteranzeige
require('script.php'); 

//Wetter Modul. Akteulle temperatur mit $ext_temp ausgeben
//include('cur_weather.php');

?>
<!DOCTYPE html>
<html lang="de">
<head>



<title>Wasserw&auml;rme im Naturfreibad Fischach</title>

<meta charset="utf-8">

<!-- Das hilft Google -->

<meta name="keywords" content="wasserwaerme, wasserw&auml;rme, wassertemperatur, fischach, naturfreibad, freibad, baden, durchschnitt, 2014, 2013" />
<meta name="description" content="Wasserwaerme ist eine praktische App, die Ihnen die Wassertemperatur im Naturfreibad Fischach übersichtlich anzeigt." />

<!-- iOS Dinge -->
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name="viewport" content="user-scalable=0, initial-scale=1.0" /> 
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<link rel="apple-touch-icon" href="<?php echo $directory; ?>apple-touch-icon-precomposed.png"/>
<meta name="format-detection" content="telephone=no">


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

<!-- Google Fonts -->
<link href='https://fonts.googleapis.com/css?family=Rubik:400,300' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Alegreya+Sans:700,500|Alegreya+Sans+SC:400,700' rel='stylesheet' type='text/css'>


<!-- Fav Icon -->
<link rel="icon" type="image/png" href="apple-touch-icon-precomposed.png" />

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo $directory; ?>jquery.plugin.js"></script>
<script src="<?php echo $directory; ?>jquery.countdown.js"></script>
<script type="text/javascript">
$(function () {
    var openingDay = new Date(2015, 05 - 1, 20, 8);
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



<!-- Script for step-by-step Counting up the Temperature -->
<script>
(function($) {
    $.fn.countTo = function(options) {
        // merge the default plugin settings with the custom options
        options = $.extend({}, $.fn.countTo.defaults, options || {});

        // how many times to update the value, and how much to increment the value on each update
        var loops = Math.ceil(options.speed / options.refreshInterval),
            increment = (options.to - options.from) / loops;

        return $(this).each(function() {
            var _this = this,
                loopCount = 0,
                value = options.from,
                interval = setInterval(updateTimer, options.refreshInterval);

            function updateTimer() {
                value += increment;
                loopCount++;
                $(_this).html(value.toFixed(options.decimals));

                if (typeof(options.onUpdate) == 'function') {
                    options.onUpdate.call(_this, value);
                }

                if (loopCount >= loops) {
                    clearInterval(interval);
                    value = options.to;

                    if (typeof(options.onComplete) == 'function') {
                        options.onComplete.call(_this, value);
                    }
                }
            }
        });
    };

    $.fn.countTo.defaults = {
        from: 0,  // the number the element should start at
        to: 100,  // the number the element should end at
        speed: 1000,  // how long it should take to count between the target numbers
        refreshInterval: 100,  // how often the element should be updated
        decimals: 1,  // the number of decimal places to show
        onUpdate: null,  // callback method for every time the element is updated,
        onComplete: null,  // callback method for when the element finishes updating
    };
})(jQuery);

jQuery(function($) {
        $('.today').countTo({
            from: 0,
            to: <?php echo str_replace(',', '.', $fasttrack_data['fasttrack_temp']); ?>,
            speed: 500,
            refreshInterval: 1,
            onComplete: function(value) {
                console.debug(this);
            }
        });
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
	
<div id="status_bar"></div> 

<div id="wrap"> 
	<div class="outside_temp"><img src="weather_icon/<?php echo $cur_weather_icon; ?>.png" height="45" width="45" style="padding: 0px 5px 0px 0px;"></div>
					                 
                    <div class="today" id="counter"></div><div class="degree">&deg;</div>                 
                    <div id="passed_time"><img src="image_store/time.png" height="15" width="15" style="padding: 0px 5px 0px 0px;"><?php echo $time_diff; ?></div>
               		<!--
               		<div class="subheadline"><img src="image_store/clock.png" height="17" width="18" style="padding: 0px 5px 0px 0px;">R&uuml;ckblick</div>
                    <div id="the_past">
	                    <div class="past_entry">
                    		<div class="past_date">
                    		 
                    		</div>
                    	
                    		<div class="min_temp">
                    		 	min
	                    	</div>
	                    	<div class="max_temp">                    		 	
                    		 	max
                    		</div>
                    	</div>
                    	<div style="clear:both;"></div>
                    	<hr />
                    	<div class="past_entry">
                    		<div class="past_date">
                    		<?php e('vor einem Tag'); ?> 
                    		</div>
                    	
                    		<div class="min_temp">
                    		 	<?php e(timemachine_minimum('-1 day', 'temperature')); ?>
	                    	</div>
	                    	<div class="max_temp">                    		 	
                    		 	<?php e(timemachine_maximum('-1 day', 'temperature')); ?>
                    		</div>
                    	</div>
                    	<div style="clear:both;"></div>
                    	<div class="past_entry">
                    		<div class="past_date">
                    		<?php e('vor zwei Tagen'); ?>  
                    		</div>
	                    	<div class="min_temp">
                    		 	<?php e(timemachine_minimum('-2 day', 'temperature')); ?>
	                    	</div>
	                    	<div class="max_temp">                    		 	
                    		 	<?php e(timemachine_maximum('-2 day', 'temperature')); ?>
                    		</div>
                    	</div>
             
                    	<div style="clear:both;"></div>
                    	<div class="past_entry">
                    		<div class="past_date">
                    		<?php e('vor einer Woche'); ?> 
                    		</div>
	                    	<div class="min_temp">
                    		 	<?php e(timemachine_minimum('-7 day', 'temperature')); ?>
	                    	</div>
	                    	<div class="max_temp">                    		 	
                    		 	<?php e(timemachine_maximum('-7 day', 'temperature')); ?>
                    		</div>
                    	</div> 
                    	<hr />
                    	<div style="clear:both;"></div>
                    	<div class="past_entry">
                    		<div class="past_date">
                    		<?php e('vor einem Jahr'); ?> 
                    		</div>
	                    	<div class="min_temp">
                    		 	<?php e(timemachine_minimum('-1 year', 'temperature')); ?>
	                    	</div>
	                    	<div class="max_temp">                    		 	
                    		 	<?php e(timemachine_maximum('-1 year', 'temperature')); ?>
                    		</div>
                    	</div> 
                    	
                    	
 
                    </div>
                    -->
                    <div class="subheadline"><img src="image_store/stats.png" height="17" width="18" style="padding: 0px 5px 0px 0px;">Statistik</div>
                  	<div id="text_summary">
	                  	<br />
	                  	<div class="stat_date">jahr</div><div class="stat_min">min</div><div class="stat_max">max</div><div class="stat_data">mittel</div>
	                  	<div style="clear:both;"></div>
	                  	<hr />
	                  	<div class="stat_date"><?php e(year('')); ?></div><div class="stat_min"><?php e(timemachine_minimum_year(''));?></div><div class="stat_max"><?php e(timemachine_maximum_year(''));?></div><div class="stat_data"><?php e(avg(''));?></div>
	                  	<div style="clear:both;"></div>
	                  	<hr />
	                  	<div class="stat_date"><?php e(year('-1 year')); ?></div><div class="stat_min"><?php e(timemachine_minimum_year('-1 year'));?></div><div class="stat_max"><?php e(timemachine_maximum_year('-1 year'));?></div><div class="stat_data"><?php e(avg('-1 year'));?></div>
	                  	<div style="clear:both;"></div>
	                  	<div class="stat_date"><?php e(year('-2 year')); ?></div><div class="stat_min"><?php e(timemachine_minimum_year('-2 year'));?></div><div class="stat_max"><?php e(timemachine_maximum_year('-2 year'));?></div><div class="stat_data"><?php e(avg('-2 year'));?></div>
	                  	<div style="clear:both;"></div>
	                  	<div class="stat_date"><?php e(year('-3 year')); ?></div><div class="stat_min"><?php e(timemachine_minimum_year('-3 year'));?></div><div class="stat_max"><?php e(timemachine_maximum_year('-3 year'));?></div><div class="stat_data"><?php e(avg('-3 year'));?></div>
	                  	<div style="clear:both;"></div>
	                  	<div class="stat_date"><?php e(year('-4 year')); ?></div><div class="stat_min"><?php e(timemachine_minimum_year('-4 year'));?></div><div class="stat_max"><?php e(timemachine_maximum_year('-4 year'));?></div><div class="stat_data"><?php e(avg('-4 year'));?></div>
	                  	<div style="clear:both;"></div>
	                  	
                  	</div>
<!--
                  <div class="subheadline"><img src="image_store/summary.png" height="17" width="18" style="padding: 0px 5px 0px 0px;">Zusammenfassung</div>
                  	<div id="text_summary">
                    <?php echo '<h5>'.$greeting.'</h5><p class="year_ago">Aktuell gerade '.$data['temperature'].'&deg; Wassertemperatur. '.$cur_weather_summary.' bei '.$cur_weather_temp.'&deg; Au&szlig;entemperatur im Naturfreibad Fischach. '.$description.' <br /> Vor einem Jahr hatte das Wasser '.timemachine('-1 year', 'temperature').'&deg; und war damit '.$comparison_phrase.'.</p>'; ?>
                  	</div>
-->
                  	<!-- Twitter Integration -->
                 
                 <div class="subheadline"><img src="image_store/twitter.png" height="17" width="19" style="padding: 0px 5px 0px 0px;">Twitter</div>
                 <div class="twitter_section">
	                 <img src="<?php echo $directory; ?>apple-touch-icon-precomposed.png" alt="App Symbol" width="50" height="50" />
	                 <a href="https://twitter.com/wassertemp" class="twitter-follow-button" data-show-count="true" data-lang="de">Follow @wassertemp</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                 </div> 
                 
                 <div class="subheadline"><img src="image_store/heart.png" height="17" width="19" style="padding: 0px 5px 0px 0px;">Credits</div>
                 	<div id="text_summary">
                 <p class="credits">Icons by Thomas Le Bas, Richard de Vos, Lucas Olaerts, Convoy, 8ties and Sergey Demushkin</p>
                 <p class="credits">Fotos by Franz Bauer</p>
                 	</div>
                 	<div id="version_information">
                 <?php echo $versioning; ?>
                 	</div>
             
</div>
<!-- Core Process ran on <?php echo $data['cur_timestamp']; ?> -->

</body>
</html>
<?php 
	//Hier ist Schluss
mysql_close($link);  
?>