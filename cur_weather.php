<?php
$json = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=Fischach&units=metric&lang=de&APPID=99b8fc52e746959adc55a6ac417e4e21");

$json = json_decode($json);

$external_temperature = round($json->main->temp);

$ext_desc = $json->weather->description;

echo $ext_desc;
?>