<?php
/*
Freibad Wassertemperatur
Datum: 10.06.2012
Setzt voraus, dass das core.php?debug=no 30min ausgeführt wird. (Core läuft gerade. Abgeschaltet am 20.09.2011. Eingeschaltet am 25.05.2012)
Setzt voraus, dass database.xml und scrape.txt mit Schreibrechten versehen sind
*/

#################
# EINSTELLUNGEN #
#################

// Version und Build-Nummer
$version = '1.5';
$build = 'a6334e';

// Hier Datum des Saison-Beginns/Ende eintragen (jeweils die Paramenter im Frontend ändern!)
// Auch das Ändern in der Index.php nicht vergessen!
$season_time = '24-05-2012 07:00:00';

// Hier die Version eintragen
$versioning = 'Version: '.$version.' ('.$build.')'; 

// Hier den Ort eintragen
$directory = 'http://wasser.aaronbauer.org/';

setlocale (LC_ALL, 'de_DE');

// Verbindungsdaten zur MySQL Datenbank stehen in mysql.php in der Variable $link
require('mysql.php');

######################

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
        
        $one_day_id = $data['id'] - 48; //Errechnet die Temperatur vom Vortag, also 48 mal die ID zurück
        
    
        // Holt die Temperatur vom Vortag, in dem die zurückgezählte ID als Marker benutzt wird. 
        $one_day_query = 'SELECT * FROM wasser WHERE id = "'.$one_day_id.'" ORDER BY id DESC';

        $one_day_data_result = mysql_query($one_day_query) or die(mysql_error());
    
        $one_day_data = mysql_fetch_array($one_day_data_result) or die(mysql_error());
        
       // Holt die Temperatur von vorgestern (also ID 96 mal zurückrechnen)
       
       
       $two_day_id = $data['id'] - 96;
       
       
	        
       $two_day_query = 'SELECT * FROM wasser WHERE ID = "'.$two_day_id.'" ORDER BY id DESC';
       
       $two_day_data_result = mysql_query($two_day_query) or die(mysql_error());
       
       $two_day_data = mysql_fetch_array($two_day_data_result) or die(mysql_error());
       
       
       
       // Holt die Temperatur von vorvorgestern (also ID 144 mal zurück)
       
     
     
        $three_day_id = $data['id'] - 144;
       
       
       $three_day_query = 'SELECT * FROM wasser WHERE ID = "'.$three_day_id.'" ORDER BY id DESC';
       
      $three_day_data_result = mysql_query($three_day_query) or die(mysql_error());
       
      $three_day_data = mysql_fetch_array($three_day_data_result) or die(mysql_error());
      
        
        
    // Query für die Darstellung als Graph mit der Google Graph API 
        
        /*    $graph_query = 'SELECT *
                                FROM 
                                   (
                                    SELECT * 
                                        FROM wasser 
                                        ORDER BY id DESC LIMIT 1000000
                                    ) 
                                AS tbl ORDER BY cur_timestamp';
        
            $graph_result = mysql_query($graph_query) or die (mysql_error());  */
        
        
    
    mysql_close($link);
};


// Ein Unix-Zeitstempel von der aktuellen Zeit
$cur_time = strtotime($data['cur_timestamp']);
// Ein Unix-Zeitstemple wann die App ausgeht
$end_time = strtotime($season_time);

// Script für den Countdown, von hier http://elouai.com/countdown-clock.php
$the_countdown_date = $end_time -1;

// make a unix timestamp for the given date
 // $the_countdown_date = mktime(23, 23, 0, 5, 18, 2012, -1); brauch ich nicht weil ich meine eigene Zeit schon habe ($end_time).

  // get current unix timestamp
  /* $today = time();

  $difference = $the_countdown_date - $today;
  if ($difference < 0) $difference = 0;

  $days_left = floor($difference/60/60/24);
  $hours_left = floor(($difference - $days_left*60*60*24)/60/60);
  $minutes_left = floor(($difference - $days_left*60*60*24 - $hours_left*60*60)/60); */
  
  // OUTPUT wird unten schon gemacht
  /*
  echo "Today's date ".date("F j, Y, g:i a")."<br/>";
  echo "Countdown date ".date("F j, Y, g:i a",$the_countdown_date)."<br/>";
  echo "Countdown ".$days_left." days ".$hours_left." hours ".$minutes_left." minutes left";


/* 
Wichtige SQL Syntax
INSERT INTO wasser (site_time, temperature) VALUES('18:00', '25');
SELECT * FROM 'wasser'
*/

//Interpretiert die Temperaturen und ordnet Text und Farbe zu
require('texts.php');


//$random_temp = rand(50,100);

// Das was angezeigt wird, wenn die Saison vorbei ist.
$end_html = '
<div id="wrap">
    
        
        <!-- Temperatur von heute -->
            <div style="width: 480px; margin-left: auto; margin-right: auto;">
                <div class="layer">
                    <h1 class="today" style="color: red;">\o/</h1>
                    <h2>Es ist vorbei!</h2>
                    <p><div id="defaultCountdown"></div></p>
                    
                    <p class="version">'.$versioning.'</p>
                </div>
            </div>
            </div>
            
            
          
            
            <!-- core war zuletzt da: '.$data['cur_timestamp'].' -->
            ';
?>