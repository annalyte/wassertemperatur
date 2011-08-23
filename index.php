<?php
/*
Freibad Wassertemperatur
Version: 0.1.2
Build: 2d4f52
Datum: 23.08.2011
*/

$versioning = 'Version: 0.1.2 (2d4f52)'; 

// Hier den Ort eintragen
$directory = 'http://wasser.aaronbauer.org';

// $date wird für das Datum im XML verwendet
$date = date('D, d M Y H:i:s');
$time = date(H.i.s);

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
for($x = 409; $x< $l_count; $x++)
{
}

for($y = 407; $y< $l_count; $y++)
{
}

fclose($fh);

/*
Aus dem Array kommt eine Temperatur (Zahl) mit Buchstaben und einem <div> dabei.  Das Array wird in die Variable alphanumeric_temp gegossen. Mit strip_tags wird der <div> entfernt. Danach heißt die Variable stripped_temp. Mit preg_replace werden dann noch die Buchstaben entfernt. Mit trim werden nun noch die Leerstellen gefiltert und es bleibt die endliche Temperatur.
Mit int wird der Wert in einen integer umgewandelt.
*/
$timestamp = trim(strip_tags($lines[407])); // Wandelt das Array der Uhrzeit in eine Variable um und entfernt HTML (strip_tags) sowie Leerstellen (trim).


$alphanumeric_temp = trim(strip_tags($lines[409])); // Wandelt das Array in eine Variable und entfernt HTML (strip_tags) sowie Leerstellen (trim).

$space_temp = preg_replace('/[a-zA-Z]/','',$alphanumeric_temp); // Entfernt Buchstaben

//$final_temp = trim($space_temp); // Entfernt Leerstellen

$temperatur = (int)$space_temp; // Wandelt Zahl in Integer um

// $temperatur = 20; // zum debuggen

/*
Die xml Datei heißt database.xml. In sie werden alle Temperaturen bei jedem Aufruf gespeichert. Die xml Datei ist als RSS-Feed in die Website eingebunden.
*/

$xml = simplexml_load_file("database.xml"); //This line will load the XML file. 

$sxe = new SimpleXMLElement($xml->asXML()); //In this line it create a SimpleXMLElement object with the source of the XML file. 
//The following lines will add a new child and others child inside the previous child created. 
$tmp_value = $sxe->addChild("item"); 
$tmp_value->addChild("title", $temperatur.' Grad'); 
$tmp_value->addChild("description", $temperatur.' Grad');
$tmp_value->addChild("link", "linkhier");
$tmp_value->addChild("pubDate", $date);
//This next line will overwrite the original XML file with new data added 
$sxe->asXML("database.xml"); 

// Die Bezeichnungen von 19-26

switch ($temperatur) {
    case 26:
        $description = 'Viel zu warm!';
        break;
    case 25:
        $description = 'Sehr warm!';
        break;
    case 24:
        $description = 'Sehr warm!';
        break;
    case 23:
        $description = 'Warm';
        break;
    case 22:
        $description = 'Angenehm';
        break;
    case 21:
        $description = 'Noch okay';
        break;
    case 20:
        $description = 'Geht so';
        break;
    case 19:
        $description = 'Kalt';
        break;        
}

?>
<html>
<head>
<title>Wassertemperatur</title>
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name="viewport" content="width = 500px, user-scalable=no">
<meta name="apple-mobile-web-app-status-bar-style" content="black">

<link rel="alternate" type="application/rss+xml" title="Wassertemperatur" href="<?php echo $directory; ?>/database.xml" />
<style type="text/css">
body {
    font-family: Helvetica, Arial, sans-serif;
    background: url(whitey.png) repeat;
    color: #333;
}

#wrap {
    width: 500px;
    margin-left: auto;
    margin-right: auto;
    text-align: center;
    margin-top: 25%;
    text-shadow: 0px 1px 1px #fff;
}

h1 {
    font-size: 90pt;
}

h2 {
    font-size: 50pt;
}
</style>
</head>
<body>
<div id="wrap">
<?php echo $versioning; ?>
<h1><?php echo $temperatur; ?>&deg;C</h1>
<h2><?php echo $description; ?></h2>
Gemessen um <?php echo $timestamp; ?>.
</div>
</body>


</html>