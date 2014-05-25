<?php
require('mysql.php');
$db_selected = mysql_select_db('d011c151', $link);

# 2012 Average

$avg = 'SELECT AVG(temperature) FROM wasser WHERE cur_timestamp >= "2012" AND cur_timestamp <= "2013"';

$avg_result = mysql_query($avg) or die (mysql_error());

$avg_data = mysql_fetch_array($avg_result) or die (mysql_error());


# 2013 Average

$two_year_avg = 'SELECT AVG(temperature) FROM wasser WHERE cur_timestamp >= "2013" AND cur_timestamp <= "2014"';

$two_year_avg_result = mysql_query($two_year_avg) or die(mysql_error());
    
$two_year_avg_data = mysql_fetch_array($two_year_avg_result) or die(mysql_error());

?>


<div id="wrap">        
                <div id="layer">
                <div id="status_bar"> <p class="date"><?php echo date('d.m.Y'); ?></p> <p class="time"><?php echo date('H:m:s').' Uhr'; ?></p> </div> 
                    <h1 class="today"> 20&deg;</h1>
                    <h2> Saisonbeginn </h2>
                    <div id="the_countdown">
                    <div id="defaultCountdown"></div>
                   
                    </div>
                    
                  
    <p class="year_ago">Jahresdurchschnitt 2013: <?php echo $two_year_avg_data['AVG(temperature)']; ?> </p>
    <p class="year_ago">Jahresdurchschnitt 2012: <?php echo $avg_data['AVG(temperature)']; ?></p>

                    <!-- Das exakte  Datum war: <?php echo $year_ago_data['cur_timestamp']; ?> -->
                 <!--   <p class="version"><?php echo $versioning; ?></p> -->
                 <!-- Twitter Integration -->
                 <p>
	                 <a href="https://twitter.com/wassertemp" class="twitter-follow-button" data-show-count="false" data-lang="de" data-show-screen-name="true" data-size="large">Follow @twitterapi</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                 </p>
                </div>
       <!--       
       <a href="graphics.php">Test</a> 
       -->        
</div>



<!-- 
<div id="wrap">


    
        
        
            <div style="width: 480px; margin-left: auto; margin-right: auto;">
                <div id="layer">
                    <h1 class="today" style="color:#00c3ff;">--&deg;C</h1>
                    <h2><?php echo $element; ?></h2>
                    <p><div id="defaultCountdown"></div></p>
                    <br />
                    <p class="version"><?php echo $versioning; ?></p>
                </div>
            </div>
            </div>
            
            
    -->      
            
            <!-- core war zuletzt da: '.$data['cur_timestamp'].' -->