<?php
// Beschreibung fŸr die aktuelle Temperatur. Bei Umlauten immer dan das richtige Unicode Zeichen denken, weil das XML sonst streikt
if($data['temperature'] == '') {
    echo 'Keine Daten.';
} else {
    switch (str_replace('.', ',', $data['temperature'])) {
	case 27:
		$description = 'Es grillt dich!';
		$color = '#ff0033';
		$bg_image = '24grad_blur.jpg';
		break;
    case 26:
        $description = 'Viel zu warm!';
        $color = '#ff0033';
        $bg_image = '24grad_blur.jpg';
        break;
    case 25:
        $description = 'Sehr warm!';
        $color = '#ff3000';
        $bg_image = '25grad_blur.jpg';
        break;
    case 24:
        $description = 'Warm!';
        $color = '#ff3000';
        $bg_image = '24grad_blur.jpg';
        break;
    case 23:
        $description = 'Warm genug.';
        $color = '#ff5202';
        $bg_image = '23grad_blur.jpg';
        break;
    case 22:
        $description = 'Angenehm.';
        $color = '#ffa600';
        $bg_image = '22grad_blur.jpg';
        break;
    case 21:
        $description = 'Das geht so.';
        $color = '#82ff06';
        $bg_image = '21grad_blur.jpg';
        break;
    case 20:
        $description = 'Etwas frisch.';
        $color = '#05ff44';
        $bg_image = '20grad_blur.jpg';
        break;
    case 19:
        $description = 'Naja.';
        $color = '#00c3ff';
        $bg_image = '19grad_blur.jpg';
        break;
    case 18:
        $description = 'Zu Kalt!';
        $color = '#00c3ff';
        $bg_image = '18grad_blur.jpg';
        break;       
	case 17:
		$description = 'Meh!';
		$color = '#00c3ff';
		$bg_image = '21grad_blur.jpg';
		break;
	case 16:
		$description = 'Ihhh!';
		$color = '#00c3ff';
		$bg_image = '16grad_blur.jpg';
		break;
	case 15:
		$description = 'Brrr!';
		$color = '#00c3ff';
		$bg_image = '15grad_blur.jpg';
		break;
	case 14:
		$description = 'LOL!';
		$color = '#31c9d5';
		break;
	case 13:
		$description = 'Haha!';
		$color = '#238f98';
		break;
	case 12:
		$description = 'Lustig!';
		$color = '#0073ff';
		break;
	case 11:
		$description = 'Nicht mehr lustig.';
		$color = '#0055bd';
		break;
	default:
		$description = 'Wassertemperatur';
		$color = '#ff00aa';    
};		
};
?>