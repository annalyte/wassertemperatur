<?php
/*
Freibad Wassertemperatur
Datum: 02.06.2013
Setzt voraus, dass das core.php?debug=no 30min ausgeführt wird.
Setzt voraus, dass database.xml mit Schreibrechten versehen sind
*/

#################
# EINSTELLUNGEN #
#################

// Version und Build-Nummer
$version = '1.6.1';
$build = 'df35a69';

// Hier Datum des Saison-Beginns/Ende eintragen (jeweils die Paramenter im Frontend ändern!)
// Auch das Ändern des Operators in der Index.php nicht vergessen! Am Ende der Saison auch den Timer einschalten
$season_time = '2013-09-16 10:00:00';

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
		# Die Tage für die alten Daten. Minus ein Jahr, miuns 3,2,1 Tage. Es wird nicht mehr mit IDs zurückgerechnet, weil Fehleranfällig

		$date_today = date('Y-m-d');

		
		$date_minus_one_year = strtotime(''.$date_today.' -1 year');
		
		$date_minus_one_day = strtotime(''.$date_today.' -1 day');
		
		$date_minus_two_day = strtotime(''.$date_today.' -2 day');
		
		$date_minus_three_day = strtotime(''.$date_today.' -3 day');
		
		
     
        # Holt die aktuelle Wassertemperatur  
        $query = 'SELECT * FROM wasser ORDER BY id DESC';
        $result = mysql_query($query) or die(mysql_error());
    
        $data = mysql_fetch_array($result) or die(mysql_error());
        
        
        # GESTERN
        
        # Erzeugt den String für gestern
        $one_day_ago_date = date('Y-m-d', $date_minus_one_day);
  
        $one_day_query = 'SELECT * FROM wasser WHERE cur_timestamp <= "'.$one_day_ago_date.'" ORDER BY id DESC';

        $one_day_data_result = mysql_query($one_day_query) or die(mysql_error());
    
        $one_day_data = mysql_fetch_array($one_day_data_result) or die(mysql_error());
        
        
        # VORGESTERN
       
       	# Erzeugt den String für vorgestern
       	$two_day_ago_date = date('Y-m-d', $date_minus_two_day);     
	        
       	$two_day_query = 'SELECT * FROM wasser WHERE cur_timestamp <= "'.$two_day_ago_date.'" ORDER BY id DESC';
       
       	$two_day_data_result = mysql_query($two_day_query) or die(mysql_error());
       
       	$two_day_data = mysql_fetch_array($two_day_data_result) or die(mysql_error());
       
       
       	# VORVORGESTERN
      
	   	# Erzeugt den String für vorvorgestern
		$three_day_ago_date = date('Y-m-d', $date_minus_three_day);       
       
		$three_day_query = 'SELECT * FROM wasser WHERE cur_timestamp <= "'.$three_day_ago_date.'" ORDER BY id DESC';
       
		$three_day_data_result = mysql_query($three_day_query) or die(mysql_error());
       
		$three_day_data = mysql_fetch_array($three_day_data_result) or die(mysql_error());
      
               
        
        # VOR EINEM JAHR
        
		# Erzeugt den String für vor einem Jahr
		$year_ago_date = date('Y-m-d', $date_minus_one_year);
        
        $year_ago_query = 'SELECT * FROM wasser WHERE cur_timestamp <= "'.$year_ago_date.'" ORDER BY id DESC';
          
		$year_ago_data_result = mysql_query($year_ago_query) or die(mysql_error());
       
		$year_ago_data = mysql_fetch_array($year_ago_data_result) or die(mysql_error());
        
        
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
$cur_time = strtotime('now');
// Ein Unix-Zeitstemple wann die App ausgeht
$end_time = strtotime($season_time);

// Script für den Countdown, von hier http://elouai.com/countdown-clock.php
//$the_countdown_date = $end_time -1;

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

#echo 'Jetzt'.$cur_time.'<br />';
#echo 'Ende'.$end_time;

//$random_temp = rand(50,100);

// PARSER DER DIE WEBSITE SCRAPED. KANN WEG. Braucht nur Rechenzeit und wird nich verwendet. 

require 'simple_html_dom.php';

$html = file_get_html('http://www.naturfreibad-fischach.de/');

if(!$html) {
	// Wenn Naturfreibad-Fischach.de down ist wird das Scrapen übersprungen und die Fehlermeldung angezeigt
	echo '<div align="center">Naturfreibad Fischach ist gerade nicht erreichbar.</div>';
	
	
} else {
	// Wenn die Website verfügbar ist wird gescraped.
	foreach($html->find('div[id=oeffdat2]') as $element) 
       #echo $element->plaintext . '<br>';

	// Das was angezeigt wird, wenn die Saison vorbei ist.
	$end_html = '
<div id="wrap">
    
        
        <!-- Temperatur von heute -->
            <div style="width: 480px; margin-left: auto; margin-right: auto;">
                <div id="layer">
                    <h1 class="today" style="color:#00c3ff;">--&deg;C</h1>
                    <h2>'.$element.'</h2>
                    <p><div id="defaultCountdown"></div></p>
                    <br />
                    <p class="version">'.$versioning.'</p>
                </div>
            </div>
            </div>
            
            
          
            
            <!-- core war zuletzt da: '.$data['cur_timestamp'].' -->
             ';

}; // Da endet das If Statement welches nachsieht ob die Seite down ist
?>