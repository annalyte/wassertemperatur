<?php
/*
Daemon which fetches the temperature and the time from the website every hour and writes it into a database.
*/

// Hier den Ort eintragen deprecated for deamon
//$directory = 'http://wasser.aaronbauer.org';

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

/*    
file_get_contents scraped die URL
$myfile öffnet die Datei scrape.txt. Dort wird die gescrpate Website reingeschrieben.
*/

$url = 'http://www.naturfreibad-fischach.de';
$output = file_get_contents($url); 

$myfile = 'scrape.txt';
$fh = fopen($myfile, 'w') or die ('Kann Datei nicht öffnen');
fwrite($fh, $output);

/*
Sucht die Zeile in der die Temperatur steht. $x ist dabei die Zeile. $lines ist dann das dazugehörige Array. $y ist die Zeile in der der Zeitpunkt der Messung steht. 
*/

$lines = file($myfile);
$l_count = count($lines);
// Die Temperatur
for($x = 409; $x< $l_count; $x++)
{
}
// Die Zeit
for($y = 407; $y< $l_count; $y++)
{
}
// Das Datum
for($z = 406; $y< $l_count; $y++)
{
}

fclose($fh);

/*
Aus dem Array kommt eine Temperatur (Zahl) mit Buchstaben und einem <div> dabei.  Das Array wird in die Variable alphanumeric_temp gegossen. Mit strip_tags wird der <div> entfernt. Danach heißt die Variable stripped_temp. Mit preg_replace werden dann noch die Buchstaben entfernt. Mit trim werden nun noch die Leerstellen gefiltert und es bleibt die endliche Temperatur.
Mit int wird der Wert in einen integer umgewandelt.
*/

//ZEIT: Überprüft, ob überhaupt eine Zeit angegeben wurde
if($lines[407] == '') {
    echo 'Keine Zeit angegeben.';
} else {

$timestamp = trim(strip_tags($lines[407])); // Wandelt das Array der Uhrzeit in eine Variable um und entfernt HTML (strip_tags) sowie Leerstellen (trim).

};

//DATUM: Überprüft, ob überhaupt ein Datum angegeben wurde
if($lines[406] == '') {
    echo 'Kein Datum angegeben.';
} else {

$site_date = trim(strip_tags($lines[406])); // Wandelt das Array des Datums in eine Variable um und entfernt HTML (strip_tags) sowie Leerstellen (trim).
};

$alphanumeric_temp = trim(strip_tags($lines[409])); // Wandelt das Array in eine Variable und entfernt HTML (strip_tags) sowie Leerstellen (trim).

$space_temp = preg_replace('/[a-zA-Z]/','',$alphanumeric_temp); // Entfernt Buchstaben

//$final_temp = trim($space_temp); // Entfernt Leerstellen

//Überprüft, ob überhaupt eine Temperatur vorhanden ist
if($space_temp == '') {
    $temperatur = '00';
} else {

$temperatur = (int)$space_temp; // Wandelt Zahl in Integer um

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

$xml = simplexml_load_file("database.xml"); //This line will load the XML file. 

$sxe = new SimpleXMLElement($xml->asXML()); //In this line it create a SimpleXMLElement object with the source of the XML file. 
//The following lines will add a new child and others child inside the previous child created. 
$tmp_value = $sxe->addChild("item"); 
$tmp_value->addChild("title", $temperatur.' Grad'); 
$tmp_value->addChild("description", $temperatur.' Grad');
$tmp_value->addChild("pubDate", $date);
//This next line will overwrite the original XML file with new data added 
$sxe->asXML("database.xml"); 

//for debug: shows the absolute path of the script

echo ' Script in:<b>' .$_SERVER['SCRIPT_FILENAME'].'</b>';


?>