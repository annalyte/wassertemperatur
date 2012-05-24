<?php
/*
Daemon 1.0.1
Build: bef6b0
The heart and soul of this app.
*/
$version = '1.1';
$build = 'bef6b0';

$versioning = 'Version: '.$version.' ('.$build.')'; 
/*
Daemon which fetches the temperature and the time from the website every hour and writes it into a database.
*/

// Hier den Ort eintragen deprecated for deamon
//$directory = 'http://wasser.aaronbauer.org';

// $date wird für das Datum im XML verwendet
$date = date('D, d M Y H:i:s T');

// Die Zeilen, woher die Daten genommen werden sollen (wird das geändert, müssen auch noch die Zeilennummern bei den Filtern getauscht werden.
// Zeile der Temperatur (immer eins weniger wie die tatsächliche Position der Daten)
$line_temp = 408;
// Zeile der Zeit
$line_time = 402;
// Zeile des Datums
$line_date = 406;

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


// Sucht den Inhalt der oben angegeben Zeilen
$lines = file($myfile);
$l_count = count($lines);
// Die Temperatur
for($line_temp; $line_temp< $l_count; $line_temp++)
{
}
// Die Zeit
for($line_time; $line_time< $l_count; $line_time++)
{
}
// Das Datum
for($line_date; $line_date< $l_count; $line_date++)
{
}

fclose($fh);

/*
Aus dem Array kommt eine Temperatur (Zahl) mit Buchstaben und einem <div> dabei.  Das Array wird in die Variable alphanumeric_temp gegossen. Mit strip_tags wird der <div> entfernt. Danach heißt die Variable stripped_temp. Mit preg_replace werden dann noch die Buchstaben entfernt. Mit trim werden nun noch die Leerstellen gefiltert und es bleibt die endliche Temperatur.
Mit int wird der Wert in einen integer umgewandelt.
*/

//ZEIT: Überprüft, ob überhaupt eine Zeit angegeben wurde
if($lines[402] == '') {
    echo 'Keine Zeit angegeben.';
} else {

//$timestamp = trim(strip_tags($lines[402])); // Wandelt das Array der Uhrzeit in eine Variable um und entfernt HTML (strip_tags) sowie Leerstellen (trim).

};

//DATUM: Überprüft, ob überhaupt ein Datum angegeben wurde
if($lines[406] == '') {
    echo 'Kein Datum angegeben.';
} else {

//$site_date = trim(strip_tags($lines[403])); // Wandelt das Array des Datums in eine Variable um und entfernt HTML (strip_tags) sowie Leerstellen (trim).
};

//TEMPERATUR: Überprüft, ob Temperatur angegeben wurde
if($lines[408] == '') {
	echo 'Keine Temperatur angegeben.';
} else {
	
};

$arr1 = str_split(strip_tags($lines[408])); // Macht aus Zeile 408 wo Zeit und Temperatur stehen ein Array um die Zeichen auszusortieren

echo '<h1>Daemon Information</h1>';

$site_date = trim(preg_replace('/[a-zA-Z]/','',strip_tags($lines[406]))); //Das Datum wird vom HTML befreit, von Buchstaben und von Leerstellen (trim)

//Nur zum Anzeigen
echo 'Date 406:'.$lines[406].'<br />';
echo 'Time 402:'.$lines[402].'<br />';
echo 'Temp 408:'.$lines[408].'<br />';
        
$temp_implode = implode(range($arr1[11], $arr1[12])); //Der 11. und 12. Teil des Arrays ist die Temperatur
    
$temperatur = (int)$temp_implode; //Macht Integer aus String

$time_range = array_slice($arr1, 0, 9); //Bei 0 wird begonnen, nach 9 Teilen wird abgeschnitten

$timestamp = implode($time_range); // Aus dem Array wird ein String

//Nur zum Anzeigen
echo '<h2>Submitted Data</h2>';
    
echo 'Temp: '.$temperatur;
echo '<br />Date: '.$site_date;
echo '<br />Time: '.$timestamp;

echo '<br /><br />';


   
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

echo ' Script in: <b>' .$_SERVER['SCRIPT_FILENAME'].'</b>';
echo '<br />'.$versioning;

?>