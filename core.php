<?php
/*
Core 1.3
Build: 3a0dffc
The heart and soul of this app.
*/
$version = '1.3';
$build = '3a0dffc';

$versioning = 'Version: '.$version.' ('.$build.')'; 
/*
Core which fetches the temperature and the time from the website every hour and writes it into a database.
*/

// Damit in der Titelzeile etwas drinsteht
echo '<title>Core '.$version.'</title>';

// $date wird für das Datum im XML verwendet
$date = date('D, d M Y H:i:s T');


// Holt die Datenbank Benutzerinformationen
require('mysql.php');

// Verbindung herstellen
if(!$link) {
    die('Keine Verbindung: '.mysql_error());
};

/* 
Wichtige Syntax
INSERT INTO wasser (site_time, temperature) VALUES('18:00', '25');
SELECT * FROM 'wasser'
*/


echo '<h1>Core - '.$versioning.'</h1>';

require 'simple_html_dom.php';

$html = file_get_html('http://www.naturfreibad-fischach.de/');

foreach($html->find('div[id=oeffdat2]') as $element) 
       #echo $element->plaintext . '<br>';
       
$arr1 = str_split(strip_tags($element));

function print_r_html ($arr) {
        ?><pre><?
        print_r($arr);
        ?></pre><?
} 
//Benutzt die funktion print_r_html statt print_r, wegen besserer Darstellung
print_r_html($arr1);


$site_date = implode(array_slice($arr1, 0, 10));

$site_time = trim(implode(array_slice($arr1, 22, 5)));
       
$temperatur_raw = implode(array_slice($arr1, -12, 3));

$temperatur = (int)$temperatur_raw;


$timestamp = $site_time.' Uhr'; // Das Uhr wird wird hardgecoded, weils die Bademeister verbummeln

// Alter Code der die Filter beinhaltet und deshalb zum Nachschauen hier bleibt

#$site_date = trim(preg_replace('/[a-zA-Z_ %\[\]\:\(\)%&-,]/s','',strip_tags($lines[413]))); //Das Datum wird vom HTML befreit, von Buchstaben und von Leerstellen (trim)
        
#$temp_implode = implode(array_slice($arr1, 12, 2)); //Der 11. und 12. Teil des Arrays ist die Temperatur. Bei 11 wird begonnen, 2 Zeichen werden mitgenomen
    
#$temperatur = (int)$temp_implode; //Macht Integer aus String

//$temperatur_slice = trim(preg_replace('/[a-zA-Z_ %\[\]\.\(\)%&-]/s','',$lines[416])); //Die Temperatur wird vom HTML befreit, von Buchstaben und von Leerstellen (trim)


//Nur zur Ansicht
echo '<h2>Submitted Data</h2>';
    
echo 'Temp: '.$temperatur;
echo '<br />Date: '.$site_date;
echo '<br />Time: '.$timestamp;

echo '<br /><br />';

if($temperatur and $site_date and $timestamp != '') {
	echo '<font color="green"><b>Relax. Everything seems to be okay! &#10003; </b></font><br />';
} else {
	echo '<font color="red"><b>It looks like you are in trouble!</b></font> <br />';
	$error = TRUE; 	
};

//Debug Modus beendet das Script hier. Es werden keine Daten geschrieben.
if($_GET['debug'] != '') {
	echo 'Debug Off <br />';
	echo '<a href="http://wasser.aaronbauer.org/core.php?debug=yes">Switch Debug On</a><br /><br />';	
	
} else {
	echo '<br />Debug Mode';
	exit;
};



   
// Auswählen der Datenbank

$db_selected = mysql_select_db('d011c151', $link);

if(!$db_selected) {
    die ('Kann Datenbank nicht nutzen: ' .mysql_error());
} else {
       
    $write_query = 'INSERT INTO wasser (temperature, site_time, site_date) VALUES ('.$temperatur.', "'.$timestamp.'", "'.$site_date.'");';
    $exec_write = mysql_query($write_query) or die(mysql_error());
    echo 'Neue Temperatur geschrieben: ';
    /*
    $row = mysql_fetch_array($result) or die(mysql_error());
    echo $row['temperature'];
    echo $row['site_time'];
    echo 'Executed';
    */
    
    $read_query = 'SELECT * FROM wasser ORDER BY id DESC';
    $exec_read = mysql_query($read_query) or die(mysql_error());
    
    $data = mysql_fetch_array($exec_read) or die(mysql_error());   
    
    echo 'Temperatur gelesen.';
    
    mysql_close($link);
};

/*
Die xml Datei heißt database.xml. In sie werden alle Temperaturen bei jedem Aufruf gespeichert. Die xml Datei ist als RSS-Feed in die Website eingebunden.
*/

require('texts.php');

echo '<br />Im XML steht: '.$temperatur.' Grad. '.$description;

$xml = simplexml_load_file("database.xml"); //This line will load the XML file. 

$sxe = new SimpleXMLElement($xml->asXML()); //In this line it create a SimpleXMLElement object with the source of the XML file. 
//The following lines will add a new child and others child inside the previous child created. 
$tmp_value = $sxe->addChild("item"); 
$tmp_value->addChild("title", $temperatur.' Grad'); 
$tmp_value->addChild("description", $temperatur.' Grad. '.$description);
$tmp_value->addChild("pubDate", $date);
//This next line will overwrite the original XML file with new data added 
$sxe->asXML("database.xml"); 

//for debug: shows the absolute path of the script

echo ' Script in: <b>' .$_SERVER['SCRIPT_FILENAME'].'</b>';
echo '<br />'.$versioning;

?>