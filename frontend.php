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
$version = '1.6.2';
$build = 'XXXXXX';

// Hier Datum des Saison-Beginns/Ende eintragen (jeweils die Paramenter im Frontend ändern!)
// Auch das Ändern des Operators in der Index.php nicht vergessen! Am Ende der Saison auch den Timer einschalten
$season_time = '2013-09-16 10:00:00';

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
		# Die Tage für die alten Daten. Minus ein Jahr, miuns 3,2,1 Tage. Es wird nicht mehr mit IDs zurückgerechnet, weil Fehleranfällig

		$date_today = date('Y-m-d H:m:s');

		
		$date_minus_one_year = strtotime(''.$date_today.' -1 year');
		
		$date_minus_one_day = strtotime(''.$date_today.' -24 hour');
		
		$date_minus_two_day = strtotime(''.$date_today.' -48 hour');
		
		$date_minus_three_day = strtotime(''.$date_today.' -72 hour');
		
		
     
        # Holt die aktuelle Wassertemperatur  
        $query = 'SELECT * FROM wasser ORDER BY id DESC';
        $result = mysql_query($query) or die(mysql_error());
    
        $data = mysql_fetch_array($result) or die(mysql_error());
        
        
        # GESTERN
        
        # Erzeugt den String für gestern
        $one_day_ago_date = date('Y-m-d H:m:s', $date_minus_one_day);
  
        $one_day_query = 'SELECT * FROM wasser WHERE cur_timestamp <= "'.$one_day_ago_date.'" ORDER BY id DESC';

        $one_day_data_result = mysql_query($one_day_query) or die(mysql_error());
    
        $one_day_data = mysql_fetch_array($one_day_data_result) or die(mysql_error());
        
        
        # VORGESTERN
       
       	# Erzeugt den String für vorgestern
       	$two_day_ago_date = date('Y-m-d H:m:s', $date_minus_two_day);     
	        
       	$two_day_query = 'SELECT * FROM wasser WHERE cur_timestamp <= "'.$two_day_ago_date.'" ORDER BY id DESC';
       
       	$two_day_data_result = mysql_query($two_day_query) or die(mysql_error());
       
       	$two_day_data = mysql_fetch_array($two_day_data_result) or die(mysql_error());
       
       
       	# VORVORGESTERN
      
	   	# Erzeugt den String für vorvorgestern
		$three_day_ago_date = date('Y-m-d H:m:s', $date_minus_three_day);       
       
		$three_day_query = 'SELECT * FROM wasser WHERE cur_timestamp <= "'.$three_day_ago_date.'" ORDER BY id DESC';
       
		$three_day_data_result = mysql_query($three_day_query) or die(mysql_error());
       
		$three_day_data = mysql_fetch_array($three_day_data_result) or die(mysql_error());
      
               
        
        # VOR EINEM JAHR
        
		# Erzeugt den String für vor einem Jahr
		$year_ago_date = date('Y-m-d H:m:s', $date_minus_one_year);
        
        $year_ago_query = 'SELECT * FROM wasser WHERE cur_timestamp <= "'.$year_ago_date.'" ORDER BY id DESC';
          
		$year_ago_data_result = mysql_query($year_ago_query) or die(mysql_error());
       
		$year_ago_data = mysql_fetch_array($year_ago_data_result) or die(mysql_error());

# Testet ob das Zeit zurückrechnen richtig funktioniert        
#  echo $one_day_data['cur_timestamp'].'<br />';
#  echo $two_day_data['cur_timestamp'].'<br />';
#  echo $three_day_data['cur_timestamp'].'<br />'; 
#  echo $year_ago_data['cur_timestamp'].'<br />';     
    // Query für die Darstellung als Graph mit der Google Graph API 
               
    mysql_close($link);
};


// Ein Unix-Zeitstempel von der aktuellen Zeit
$cur_time = strtotime('now');
// Ein Unix-Zeitstemple wann die App ausgeht
$end_time = strtotime($season_time);


//Interpretiert die Temperaturen und ordnet Text und Farbe zu
require('texts.php');

#echo 'Jetzt'.$cur_time.'<br />';
#echo 'Ende'.$end_time;


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