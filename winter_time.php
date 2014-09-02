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


# 2014 Average

$three_year_avg = 'SELECT AVG(temperature) FROM wasser WHERE cur_timestamp >= "2014" AND cur_timestamp <= "2015"';

$three_year_avg_result = mysql_query($three_year_avg) or die(mysql_error());
    
$three_year_avg_data = mysql_fetch_array($three_year_avg_result) or die(mysql_error());

?>



                   

<div id="wrap">                   
                    <div class="today"><?php echo $external_temperature; ?></div><div class="degree">&deg;</div>                 
                    <div id="passed_time"><div id="defaultCountdown"></div></div>
              <!--      
                    <div id="timemachine">
                    	<div id="timemachine_icon"><img src="image_store/timemachine.png" height="120" width="120" /></div>
                    	<div id="timemachine_temp_box">
	                    	<h2><?php echo $year_ago_data['temperature'] ?></h2>
	                    	<p>2013</p>
                    	</div>
                    </div>
               -->
               
                    <div id="the_past">
                    	<div class="past_entry">
                    		<div class="past_date">
                    		2014 
                    		</div>
                    	
                    		<div class="past_temp">
                    			&oslash; <?php echo round($three_year_avg_data['AVG(temperature)'], 2); ?>
                    		</div>
                    	</div>
                    	<div style="clear:both;"></div>
                    	<div class="past_entry">
                    		<div class="past_date">
                    		2013  
                    		</div>
	                    	<div class="past_temp">
                    		&oslash; <?php echo round($two_year_avg_data['AVG(temperature)'], 2); ?>
                    		</div>
                    	</div>
                    	<div style="clear:both;"></div>
                    	<div class="past_entry">
                    		<div class="past_date">
                    		2012 
                    		</div>
	                    	<div class="past_temp">
                    		&oslash; <?php echo round($avg_data['AVG(temperature)'], 2); ?>
                    		</div>
                    	</div> 
                    	
                    	
 
                    </div>
                  
                    <?php echo '<p class="year_ago">Die Au&szlig;entemperatur im Naturfreibad Fischach betr&aumlgt gerade '.$external_temperature.' Grad.</p>'; ?>
                    
                    <!-- Das exakte  Datum war: <?php echo $year_ago_data['cur_timestamp']; ?> -->
                 <!--   <p class="version"><?php echo $versioning; ?></p> -->
                 <!-- Twitter Integration -->
                 <!--
                 <p>
	                 <a href="https://twitter.com/wassertemp" class="twitter-follow-button" data-show-count="true" data-lang="de">Follow @wassertemp</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                 </p> 
                 <p><?php echo $ext_temp; ?></p>  -->   
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