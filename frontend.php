<?php
/*
Freibad Wassertemperatur
Datum: 04.09.2011
Setzt voraus, dass das daemon.php 30min ausgeführt wird. (Daemon läuft gerade NICHT. Abgeschaltet am 20.09.2011. Eingeschaltet am 25.05.2012)
Setzt voraus, dass database.xml und scrape.txt mit Schreibrechten versehen sind
*/

#################
# EINSTELLUNGEN #
#################

// Version und Build-Nummer
$version = '1.4';
$build = 'f88f8d';

// Hier Datum des Saison-Beginns/Ende eintragen (jeweils die Paramenter im Frontend ändern!)
// Auch das Ändern in der Index.php nicht vergessen!
$season_time = '24-05-2012 07:00:00';

// Hier die Version eintragen
$versioning = 'Version: '.$version.' ('.$build.')'; 

// Hier den Ort eintragen
$directory = 'http://wasser.aaronbauer.org/';

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
    
        // Holt die Temperatur vom Vortag, in dem der letzte Eintrag der nicht dem aktuellen Datum entspricht ausgegeben wird
        $previous_query = 'SELECT * FROM wasser
WHERE site_date <> "'.$data['site_date'].'" ORDER BY id DESC';

        $previous_data_result = mysql_query($previous_query) or die(mysql_error());
    
        $previous_data = mysql_fetch_array($previous_data_result) or die(mysql_error());
        
        
    // Query für die Darstellung als Graph mit der Google Graph API 
        
            $graph_query = 'SELECT *
                                FROM 
                                   (
                                    SELECT * 
                                        FROM wasser 
                                        ORDER BY id DESC LIMIT 1000000
                                    ) 
                                AS tbl ORDER BY cur_timestamp';
        
            $graph_result = mysql_query($graph_query) or die (mysql_error());
        
        
    
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
  $today = time();

  $difference = $the_countdown_date - $today;
  if ($difference < 0) $difference = 0;

  $days_left = floor($difference/60/60/24);
  $hours_left = floor(($difference - $days_left*60*60*24)/60/60);
  $minutes_left = floor(($difference - $days_left*60*60*24 - $hours_left*60*60)/60);
  
  // OUTPUT wird unten schon gemacht
  /*
  echo "Today's date ".date("F j, Y, g:i a")."<br/>";
  echo "Countdown date ".date("F j, Y, g:i a",$the_countdown_date)."<br/>";
  echo "Countdown ".$days_left." days ".$hours_left." hours ".$minutes_left." minutes left";
*/

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

//$random_temp = rand(50,100);

// Das was angezeigt wird, wenn die Saison vorbei ist.
$end_html = '
<div id="wrap">
    <div id="slider_content" style="width: 320px; height: 460px; overflow: hidden;">
        
        <!-- Temperatur von heute -->
            <div id="slide1" style="height: 460px; width: 320px; float:left;">
                <div class="layer">
                    <h1 class="today" style="color: red;">15&deg;C</h1>
                    <h2>Es wird ernst!</h2>
                    <p><div id="defaultCountdown"></div></p>
                    
                    <p class="version">'.$versioning.'</p>
                </div>
            </div>
            </div>
            
          
            
            <!-- Daemon war zuletzt da: '.$data['cur_timestamp'].' -->
            ';
?>