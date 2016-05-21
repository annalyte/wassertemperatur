<?php
// Script.php is successor of frontend.php
// 1.9 Embedded new weather service forecast.io, optical enhancements, background now according to weather conditions, implented fasttrack.php for faster recognition of changes, new icon, icons and background match weather conditions, weather conditions on top
// 1.9.1 Changed view of weather forecast on top, added small clock icon to indicate the passed time, re-implemented twitter, little brighter text, fixed hr
// 1.9.2 Fixed Bug with year count, added fourth year to statistics / Deprecated Season Time Feature  
setlocale (LC_ALL, 'de_DE');
date_default_timezone_set('Europe/Berlin');
// Version Information from GitHub
$version = '1.9.2';
$build = 'XXXXXX';

$versioning = 'Version: '.$version.' ('.$build.')'; 

###########
#DIRECTORY#
###########

$directory = 'http://wasser.aaronbauer.org/';

// Das Datum muss dieses Format haben, damit wir rechnen können
$date_today = date('Y-m-d H:i:s');

// Wir brauchen ein Datum ohne Uhrzeit für die Vergangenheit
$midnight_date = date('Y-m-d');

// Brauchen wir für Jahresdurchschnitte
$year_date = date('Y');


include('forecast.php');

// Verbindungsdaten zur MySQL Datenbank stehen in mysql.php in der Variable $link
require('mysql.php');

if(!$link) {
    die('Keine Verbindung: '.mysql_error());
};

// Auswählen der Datenbank
$db_selected = mysql_select_db('d011c151', $link);


// Hier kann gearbeitet werden
if(!$db_selected) {
    die ('Kann Datenbank nicht nutzen: ' .mysql_error());
} else {
	
	function e ($var) {
		echo $var;
	}
	
	function br() {
		echo '<br />';
	}
	
	function timemachine($intervalstring, $field) {
		$date_string = date('Y-m-d H:i:s', strtotime("$date_today $intervalstring"));
		$timemachine_query = 'SELECT * FROM wasser WHERE cur_timestamp <= "'.$date_string.'" ORDER BY id DESC'; 
		$timemachine_data = mysql_fetch_array(mysql_query($timemachine_query)) or die(mysql_error());
		return $timemachine_data["$field"];
	}
	
	function timemachine_maximum($intervalstring) {
		$requested_date = date('Y-m-d', strtotime("$midnight_date $intervalstring"));
		$plus_one = '+1 day';
		$requested_date_plus_one = date('Y-m-d', strtotime("$requested_date $plus_one"));
		$maximum_query = 'SELECT MAX(temperature) AS "MaxTemp" FROM wasser WHERE cur_timestamp >= "'.$requested_date.'" AND cur_timestamp < "'.$requested_date_plus_one.'" ORDER BY id DESC';
		$maximum_data = mysql_fetch_array(mysql_query($maximum_query)) or die(mysql_error());
		return $maximum_data['MaxTemp'];
	}
	
	function timemachine_minimum($intervalstring) {
		$requested_date = date('Y-m-d', strtotime("$midnight_date $intervalstring"));
		$plus_one = '+1 day';
		$requested_date_plus_one = date('Y-m-d', strtotime("$requested_date $plus_one"));
		$minimum_query = 'SELECT MIN(temperature) AS "MinTemp" FROM wasser WHERE cur_timestamp >= "'.$requested_date.'" AND cur_timestamp < "'.$requested_date_plus_one.'" ORDER BY id DESC';
		$minimum_data = mysql_fetch_array(mysql_query($minimum_query)) or die(mysql_error());
		return $minimum_data['MinTemp'];
	}
	
	function avg($intervalstring) {
		$requested_date = date('Y', strtotime("$year_date $intervalstring"));
		$requested_date_plus_one = $requested_date + 1;
		$avg_query = 'SELECT AVG(temperature) AS "AvgTemp" FROM wasser WHERE cur_timestamp >= "'.$requested_date.'" AND cur_timestamp < "'.$requested_date_plus_one.'" ORDER BY id DESC';
		$avg_data = mysql_fetch_array(mysql_query($avg_query)) or die(mysql_error());
		return round($avg_data['AvgTemp'], 2);
	}
	
	function weekdays($intervalstring) {
		$weekday = strftime("%A", strtotime(timemachine($intervalstring, 'cur_timestamp')));
		return $weekday; 
	}
	
	function year($intervalstring) {
		$year = strftime("%Y", strtotime("$date_today $intervalstring"));
		return $year; 
	}
	
	function timemachine_maximum_year($intervalstring) {
		$requested_year = date('Y', strtotime("$year_date $intervalstring"));
		$requested_year_plus_one = $requested_year + 1;
		$maximum_year_query = 'SELECT MAX(temperature) AS "MaxYearTemp" FROM wasser WHERE cur_timestamp >= "'.$requested_year.'" AND cur_timestamp < "'.$requested_year_plus_one.'" ORDER BY id DESC';
		$maximum_year_data = mysql_fetch_array(mysql_query($maximum_year_query)) or die(mysql_error());
		return $maximum_year_data['MaxYearTemp'];
	}
	
	function timemachine_minimum_year($intervalstring) {
		$requested_year = date('Y', strtotime("$year_date $intervalstring"));
		$requested_year_plus_one = $requested_year + 1;
		$minimum_year_query = 'SELECT MIN(temperature) AS "MinYearTemp" FROM wasser WHERE cur_timestamp >= "'.$requested_year.'" AND cur_timestamp < "'.$requested_year_plus_one.'" ORDER BY id DESC';
		$minimum_year_data = mysql_fetch_array(mysql_query($minimum_year_query)) or die(mysql_error());
		return $minimum_year_data['MinYearTemp'];
	}
	
	//Holt die aktuelle Wassertemperatur - alter Code, wird aber noch gebraucht 
    $query = 'SELECT * FROM wasser ORDER BY id DESC';
    $result = mysql_query($query) or die(mysql_error());
    $data = mysql_fetch_array($result) or die(mysql_error());
    
    //Die Überholspur, damit die App aktuellere Daten anzeigt
    $fasttrack_query = 'SELECT * FROM fasttrack';
    $fasttrack_result = mysql_query($fasttrack_query) or die(mysql_error());
    $fasttrack_data = mysql_fetch_array($fasttrack_result) or die(mysql_error());
    
    //Nur zu Testzwecken 
    $test_query = 'SELECT * FROM wasser WHERE cur_timestamp >= "2015-06-17" ORDER BY id ASC';
    $test_result = mysql_query($test_query) or die(mysql_error());
    $test_data = mysql_fetch_array($test_result) or die(mysql_error());
    	
};

// Ein Unix-Zeitstempel von der aktuellen Zeit
$cur_time = strtotime('now');
// Ein Unix-Zeitstemple wann die App ausgeht
$end_time = strtotime($season_time);

// Zeitdifferenz zwischen unix_timestamp und aktueller Zeit ausrechnen
$time_diff_calc = round((($cur_time - $data['unix_timestamp']) / 60) / 60);

// Wenn Zeitdifferenz nur eine Stunde ist muss es anders heißen und das Gradzeichen pulsiert nicht immer ($pulsation)
if ($time_diff_calc == 1) {
	$time_diff = 'vor einer Stunde';
} elseif($time_diff_calc < 1) {
	$time_diff = 'aktuell';
} elseif($time_diff_calc > 24) {
	$time_diff = 'vor über einem Tag';
	$pulsation = 'No';
} elseif($time_diff_calc > 48) {
	$time_diff = 'vor über zwei Tagen';
	$pulsation = 'No';
} else {
	$time_diff = 'vor '.$time_diff_calc.' Std.';
	$pulsation = 'No';
};



//Interpretiert die Temperaturen und ordnet Text und Farbe zu
require('texts.php');

//Bestimmt die Grußformel für den Fließtext
if (date('H:m:i') < '11:00:00') {
	$greeting = 'Guten Morgen! ';
} elseif (date('H:m:i') > '16:00:00') {
	$greeting = 'Guten Abend! ';
} else {
	$greeting = 'Hi! ';
};


if($data['temperature'] < timemachine('-1 year','temperature')) {
	$comparison_phrase = 'w&auml;rmer als heute'; } 
elseif($data['temperature'] > timemachine('-1 year','temperature')) {
	$comparison_phrase = 'k&uuml;hler als heute'; } 
elseif($data['temperature'] == timemachine('-1 year','temperature')) {
	$comparison_phrase = 'genauso wie heute';
};
	                  
if($data['opening'] == 1) {
	$opening_phrase = ' scheint gerade ge&ouml;ffnet zu sein';
} else {
	$opening_phrase = ' ist momentan wohl geschlossen';
};
        
?>