<?php 
$directory = 'http://wasser.aaronbauer.org/';
/*
Core which fetches the temperature and the time from the website every hour and writes it into a database.
*/

// Damit alles seine Ordnung hat
header('Content-Type: text/html; charset=UTF-8');

include('cur_weather.php');

// Damit in der Titelzeile etwas drinsteht
echo '<title>Fasttrack Module</title>';

// $date wird für das Datum im XML verwendet
$date = date('r');

// Holt die Datenbank Benutzerinformationen
require('mysql.php');

// Verbindung herstellen
if(!$link) {
    die('Keine Verbindung: '.mysql_error());
};


echo '<h1>Fasttrack Module</h1>';

require 'simple_html_dom.php';

$html = file_get_html('http://www.naturfreibad-fischach.de/');

foreach($html->find('div[class=big-text flippy]') as $element) 
       #echo $element->plaintext . '<br>';
       

// Array wird gleich bereingt von allem unfung vs. ...   $arr1 ist für Temperatur, Zeit, Datum, (Zahlen); $arr_opening nur für die Offen/Geschlossen (wegen den Buchstaben, die wir hier benötigen)    
$arr1 = str_split(preg_replace('/[a-zA-Z_ %\[\]\;\¶\s+\Ã\(\)%&-]/','',strip_tags($element)));

$arr_opening = str_split(preg_replace('/[\]\;\(\)%&-]/','',strip_tags($element)));
      
// Array wird kaum bereinigt. Mal sehen was besser hält. 
#$arr1 = str_split(strip_tags($element));

//Damit die neue mit der alten Temperatur verglichen werden kann brauchen wir eine Datenbankverbindung
$db_selected = mysql_select_db('d011c151', $link);



#$site_date = implode(array_slice($arr1, 19, 10));

#$site_time = trim(implode(array_slice($arr1, 10, 5)));
    
//Die Temperatur muss jetzt in die richtige form gebracht werden, um später vergleichbar zu sein   
$temperatur_raw = implode(array_slice($arr1, 12, 4));

//Ersetzt das Komma durch den Punkt, da ansonsten Round nicht funktioniert
$temperatur_comma = str_replace(',', '.', $temperatur_raw);

$temperatur = round($temperatur_comma, 1);


$timestamp = round($site_time, 0).':00'; // Das 00 wird hardgecoded, daher leichte ungenaigkeit bei Zeitangabe, ist aber sicherer so

$composed_date = $site_date.' '.$timestamp; //Hier wird die Zeit und das Datum zusammengebracht

$unix_time = strtotime($composed_date); // Ein Unix Zeitstempel wird daraus

echo date("d.m.Y H:i:s", $unix_time);

echo '<br /> Unix-Zeit:'.$unix_time;

//echo $composed_date;

// Alter Code der die Filter beinhaltet und deshalb zum Nachschauen hier bleibt

#$site_date = trim(preg_replace('/[a-zA-Z_ %\[\]\:\(\)%&-,]/s','',strip_tags($lines[413]))); //Das Datum wird vom HTML befreit, von Buchstaben und von Leerstellen (trim)
        
#$temp_implode = implode(array_slice($arr1, 12, 2)); //Der 11. und 12. Teil des Arrays ist die Temperatur. Bei 11 wird begonnen, 2 Zeichen werden mitgenomen
    
#$temperatur = (int)$temp_implode; //Macht Integer aus String

//$temperatur_slice = trim(preg_replace('/[a-zA-Z_ %\[\]\.\(\)%&-]/s','',$lines[416])); //Die Temperatur wird vom HTML befreit, von Buchstaben und von Leerstellen (trim)


//Nur zur Ansicht
echo '<h2>Submitted Data</h2>';

echo 'Temperatur (original): '.$temperatur_comma;    
echo '<br />Temperatur (gerundet): '.$temperatur;




   

// Wird nur UPDATE gemacht. Hier geht es nur um Geschwindigkeit
if(!$db_selected) {
    die ('Kann Datenbank nicht nutzen: ' .mysql_error());
} else {

       
    $write_query = 'UPDATE fasttrack SET fasttrack_temp = '.$temperatur.' WHERE id = 1;';
    $exec_write = mysql_query($write_query) or die(mysql_error());
    echo 'Neue Temperatur geschrieben. <br /> ';

// Datenbankverbindung wird erst hier geschlossen       
    mysql_close($link);
};
?>