<?php
/*
Freibad Wassertemperatur
Datum: 29.08.2011
Setzt voraus, dass das daemon.php stündlich ausgeführt wird.
*/

$version = '0.7';
$build = '1c6ca3';

$versioning = 'Version: '.$version.' ('.$build.')'; 

// Hier den Ort eintragen
$directory = 'http://wasser.aaronbauer.org';

// $date wird für das Datum im XML verwendet
$date = date('D, d M Y H:i:s T');

// Verbindung zur MySQL Datenbank

require('mysql.php');

if(!$link) {
    die('Keine Verbindung: '.mysql_error());
};

// Auswählen der Datenbank

$db_selected = mysql_select_db('d011c151', $link);

if(!$db_selected) {
    die ('Kann Datenbank nicht nutzen: ' .mysql_error());
} else {
       
    $query = 'SELECT * FROM wasser ORDER BY id DESC';
    $result = mysql_query($query) or die(mysql_error());
    
    $data = mysql_fetch_array($result) or die(mysql_error());
    
    mysql_close($link);
};

/* 
Wichtige Syntax
INSERT INTO wasser (site_time, temperature) VALUES('18:00', '25');
SELECT * FROM 'wasser'
*/

/* 
Die Bezeichnungen von 18-26. Wenn $_GET auf "en" steht wird die englische Version ausgegeben. Ansonsten die normale.
$lang_link ist einfach nur der passende Link für die Website (damit das HTML sauber bleibt). 
*/
if($data['temperature'] == '00') {
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
        $description = 'Noch erträglich';
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
 


?>
<!DOCTYPE HTML>
<html>
<head>
<title>Wasser</title>

<!-- iOS Dinge -->
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name="viewport" content="width = device-width, user-scalable=no">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="apple-touch-icon-precomposed" href="<?php echo $directory; ?>/apple-touch-icon.png"/>
<link rel="apple-touch-startup-image" href="<?php echo $directory; ?>/startup.png">

<!-- Google Font -->
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>

<!-- RSS Database.xml integration -->
<link rel="alternate" type="application/rss+xml" title="Wassertemperatur" href="<?php echo $directory; ?>/database.xml" />

<!-- iPad Stylesheet -->
<link rel="stylesheet" media="only screen and (min-device-width: 768px)
and (max-device-width: 1024px)" href="<?php echo $directory; ?>/ipad.css" type="text/css" />

<!-- iPhone Stylesheet -->
<link rel="stylesheet" media="only screen and (min-device-width: 320px)
and (max-device-width: 460px)" href="<?php echo $directory; ?>/iphone.css" type="text/css" />

<!-- Computer Stylesheet -->
<link rel="stylesheet" media="only screen and (min-device-width: 1025px)" href="<?php echo $directory; ?>/standard.css" type="text/css" />

<style type="text/css">
h1 {
    font-size: 65pt;
    color: <?php echo $color; ?>;
    padding:50px 0px 0px 0px;
    opacity: 1;
    margin:0;
    
    -webkit-mask-image: -webkit-gradient(linear, left top,
    left bottom, from(rgba(0,0,0,0.5)), to(rgba(0,0,0,1)));
}

h2 {
    font-size: 20pt;
    opacity: 1;
}

p.version {
    font-size: 8pt;
    padding-top: 10px;
}

p{
    line-height: 21px;
}
</style>

</head>
<body>
<div id="wrap">
<div id="layer">
<h1><?php echo $data['temperature']; ?>&deg;C</h1>
<h2><?php echo $description; ?></h2>
<p>Gemessen am <b><?php echo $data['site_date']; ?></b> <br /> um <b><?php echo $data['site_time']; ?></b>.</p>
<p class="version"><?php echo $versioning; ?></p>
<!-- Daemon war zuletzt da: <?php echo $data['cur_timestamp']; ?> -->
</div>
</div>
</body>
</html>