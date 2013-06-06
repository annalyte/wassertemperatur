<?php

require('mysql.php');
$db_selected = mysql_select_db('d011c151', $link);


# 2012 Daten

$query = 'SELECT * FROM wasser WHERE cur_timestamp >= "2012" AND cur_timestamp <= "2013"';
 
$result = mysql_query($query) or die(mysql_error());
    
$data = mysql_fetch_array($result) or die(mysql_error());


# 2013 Daten

$two_year = 'SELECT * FROM wasser WHERE cur_timestamp >= "2013"';
 
$two_year_result = mysql_query($two_year) or die(mysql_error());
    
$two_year_data = mysql_fetch_assoc($two_year_result) or die(mysql_error());


# 2012 Average

$avg = 'SELECT AVG(temperature) FROM wasser WHERE cur_timestamp >= "2012" AND cur_timestamp <= "2013"';

$avg_result = mysql_query($avg) or die (mysql_error());

$avg_data = mysql_fetch_array($avg_result) or die (mysql_error());


# 2013 Average

$two_year_avg = 'SELECT AVG(temperature) FROM wasser WHERE cur_timestamp >= "2013" AND cur_timestamp <= "2014"';

$two_year_avg_result = mysql_query($two_year_avg) or die(mysql_error());
    
$two_year_avg_data = mysql_fetch_array($two_year_avg_result) or die(mysql_error());


$first_data = array();

$second_data = array();

while($first_stats = mysql_fetch_assoc($result)) {
	$first_data[] = $first_stats;
}

while($second_stats = mysql_fetch_assoc($two_year_result)) {
	$second_data[] = $second_stats;
}

#foreach($first_data as $first_stats){
	#echo '["'.$first_stats['site_date'].'", '.$first_stats['temperature'].', '.$first_stats['temperature'].'],';
#}

#foreach($second_data as $second_stats) {
	#print_r($second_stats['temperature']);
#}

echo $second_data;

/* 
while($statistic = mysql_fetch_array($result)) {
    echo '["'.$statistic['site_date'].'", '.$statistic['temperature'].'], ';
}; */

?>
<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', '2012', '2013'],
         <?php foreach($first_data as $first_stats){
	echo '["'.$first_data['site_date'].'", '.$first_data['temperature'].', '.$second_data['temperature'].'],';
}   ?>
        ]);

        var options = {
          title: 'Temperature',
          fontName: 'Monaco',
          fontSize: '13',
          lineWidth: '3'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
  <h1>Statistics</h1>
    <div id="chart_div" style="width: 2500px; height: 400px;"></div>
    <p>2012 Average: <?php echo $avg_data['AVG(temperature)']; ?></p>
    <p>2013 Average: <?php echo $two_year_avg_data['AVG(temperature)']; ?> </p>
    
    Delta: <?php $delta =  $two_year_avg_data['AVG(temperature)'] - $avg_data['AVG(temperature)']; echo $delta; ?>
    
    <?php #while($two_year_statistics = mysql_fetch_array($two_year_result)) {
   # echo $two_year_statistics['temperature'].'] ';
#};   ?>
  </body>
</html>