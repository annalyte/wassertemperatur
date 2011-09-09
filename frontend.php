<?php
/*
Freibad Wassertemperatur
Datum: 04.09.2011
Setzt voraus, dass das daemon.php stündlich ausgeführt wird.
Setzt voraus, dass database.xml und scrape.txt mit Schreibrechten versehen sind
*/

$version = '0.9.1';
$build = 'bef6b0';

$versioning = 'Version: '.$version.' ('.$build.')'; 

// Hier den Ort eintragen
$directory = 'http://wasser.aaronbauer.org/';

// Verbindungsdaten zur MySQL Datenbank stehen in mysql.php in der Variable $link
require('mysql.php');

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
    
    mysql_close($link);
};

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
?>