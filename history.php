<?php

require('mysql.php');
$db_selected = mysql_select_db('d011c151', $link);



$query = 'SELECT * FROM wasser WHERE id BETWEEN 1128 AND 9999';
 
$result = mysql_query($query) or die(mysql_error());
    
$data = mysql_fetch_array($result) or die(mysql_error());

$avg = 'SELECT AVG(temperature) FROM wasser WHERE id BETWEEN 1128 AND 9999';

$avg_result = mysql_query($avg) or die (mysql_error());

$avg_data = mysql_fetch_array($avg_result) or die (mysql_error());




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
          ['Time', 'Temperature'],
         <?php while($statistic = mysql_fetch_array($result)) {
    echo '["'.$statistic['site_date'].'", '.$statistic['temperature'].'], ';
};   ?>
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
    <div id="chart_div" style="width: 100%; height: 400px;"></div>
    <p>Average: <?php echo $avg_data['AVG(temperature)']; ?></p>
  </body>
</html>