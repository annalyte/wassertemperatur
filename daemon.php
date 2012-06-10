<?php
/*
Daemon 1.1.1
Build: bc001b
The heart and soul of this app.
*/
$version = '1.1.1';
$build = 'bc001b';

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
Aus allen Zeichen der Linie mit Wassertemp und Uhrzeit wird ein Array (arr1) gemacht anhand dessen wir dann abzählen können, welche Teile wir daraus benötigen. array_slice schneidet dabei das richtige heraus. 
*/


$arr1 = str_split(strip_tags($lines[412])); // Macht aus Zeile 408 wo Zeit und Temperatur stehen ein Array um die Zeichen auszusortieren

echo '<h1>Daemon Information - '.$versioning.'</h1>';

print_r($arr1);

$site_date = trim(preg_replace('/[a-zA-Z]/','',strip_tags($lines[410]))); //Das Datum wird vom HTML befreit, von Buchstaben und von Leerstellen (trim)

//Nur zum Anzeigen
echo '<br />';
echo 'Date 406:'.$lines[406].'<br />';
echo 'Time 402:'.$lines[402].'<br />';
echo 'Temp 408:'.$lines[408].'<br />';
        
$temp_implode = implode(array_slice($arr1, 10, 11)); //Der 11. und 12. Teil des Arrays ist die Temperatur. Bei 11 wird begonnen, 2 Zeichen werden mitgenomen
    
$temperatur = (int)$temp_implode; //Macht Integer aus String

$time_range = array_slice($arr1, 0, 9); //Bei 0 wird begonnen, nach 9 Teilen wird abgeschnitten

$timestamp = implode($time_range); // Aus dem Array wird ein String

//Nur zum Anzeigen
echo '<h2>Submitted Data</h2>';
    
echo 'Temp: '.$temperatur;
echo '<br />Date: '.$site_date;
echo '<br />Time: '.$timestamp;

echo '<br /><br />';

//Debug Modus beendet das Script hier. Es werden keine Daten geschrieben.
if($_GET['debug'] == 'yes') {
	echo 'Debug On';
	exit;
} else {
	echo '<a href="http://wasser.aaronbauer.org/daemon.php?debug=yes">Switch Debug On</a><br /><br />';	
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

echo ' Script in: <b>' .$_SERVER['SCRIPT_FILENAME'].'</b>';
echo '<br />'.$versioning;

?>