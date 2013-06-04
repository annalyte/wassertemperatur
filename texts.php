<?php
// Beschreibung fŸr die aktuelle Temperatur. Bei Umlauten immer dan das richtige Unicode Zeichen denken, weil das XML sonst streikt
if($data['temperature'] == '') {
    echo 'Keine Daten.';
} else {
    switch ($data['temperature']) {
	case 27:
		$description = 'Es grillt dich!';
		$color = '#ff0033';
		break;
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
        $description = 'Warm genug.';
        $color = '#ff5202';
        break;
    case 22:
        $description = 'Angenehm.';
        $color = '#ffa600';
        break;
    case 21:
        $description = 'Noch okay.';
        $color = '#ffdd00';
        break;
    case 20:
        $description = 'Etwas k&#252;hl.';
        $color = '#dfff00';
        break;
    case 19:
        $description = 'Kalt.';
        $color = '#00c3ff';
        break;
    case 18:
        $description = 'Zu Kalt!';
        $color = '#00c3ff';
        break;       
	case 17:
		$description = 'Brrr!';
		$color = '#00c3ff';
		break;
	case 16:
		$description = 'Ihhh!';
		$color = '#00c3ff';
		break;
	case 15:
		$description = 'Unm&#246;glich!';
		$color = '#00c3ff';
		break;
	case 14:
		$description = 'Unm&#246;glich!';
		$color = '#31c9d5';
		break;
	case 13:
		$description = 'Haha!';
		$color = '#238f98';
		break;
	case 12:
		$description = 'L&#228;cherlich!';
		$color = '#0073ff';
		break;
	case 11:
		$description = 'Nicht mehr lustig.';
		$color = '#0055bd';
		break;    
};
};
?>