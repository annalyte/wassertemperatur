

body {
	background: url(weather_img/<?php echo $cur_weather_icon.'.jpg'; ?>) no-repeat top center fixed;
	background-size: cover;
	background-color: #000;
    font-family: "HelveticaNeue-Regular", Arial, sans-serif;
    background-color: #000;
    padding:0;
    margin:0;
    

	
    -webkit-font-smoothing: antialiased;
}

div.outside_temp {
	opacity: 0.5;
	margin: 40px 0px 0px 0px;
	font-size: 12pt;
	vertical-align: center;
}

div.outside_temp img {
	vertical-align: middle;
}

div.today {
    font-size: 85pt;
    padding:0px 0px 0px 0px;
    /* text-shadow: 2px 2px 0px #333333; */
    letter-spacing: -12px;
 font-family: "HelveticaNeue-UltraLight", Arial, sans-serif;
    margin:15px 0px 15px 0px;
    color: #fff;
    position: relative;
    left: -12px;
    

}

div.degree {
	font-family: "HelveticaNeue-UltraLight", Arial, sans-serif;
	position: absolute;
	font-size: 30pt;
	top: 90px;
	left: 265px;
<?php
#Nur pulsieren, wenn es aktuell ist
if ($pulsation != 'No') {
	echo '-webkit-animation: pulsate 2s ease-out;
    -webkit-animation-iteration-count: infinite; 
    
    opacity: 0.0;';
};	
?>
	
	
}


@-webkit-keyframes pulsate {
    0% { opacity: 0.0;}
    50% {opacity: 1.0;}
    100% {opacity: 0.0;}
}


/*
h1.yesterday {
    font-size: 65pt;
    padding:50px 0px 0px 0px;
    opacity: 0.9;
    margin:0;
    font-weight: lighter;
    color:<?php echo $previous_color; ?>;
    -webkit-mask-image: -webkit-gradient(linear, left top,
    left bottom, from(rgba(0,0,0,0.1)), to(rgba(0,0,0,1)));
}
*/

/*
h2 {
    font-size: 32pt;
    font-family: "SFUIDisplay-Regular", "HelveticaNeue-Light";
	font-weight: lighter;
    /* text-shadow: 2px 2px 0px #333333; */

    color: <?php //echo $color; ?> white;
    
}

*/



h4 {
	font-size: 18pt;
}

/*
div#timemachine{
	height: 200px;
	font-family: "San Francisco Display", "HelveticaNeue-Light";
	font-weight: lighter;
	font-size: 16pt;
	margin-top: 50px;
	border-top: 1px solid #fff;

}

div#timemachine_icon {
	float:left;
}

div#timemachine_temp_box {
	float:right;
}

*/

div#passed_time {
	font-size: 12pt;
	margin: 0px 0px 0px 0px;
	opacity: 0.5;
	
}

p.version {
    font-size: 8pt;
    margin-top: 110px;
}

div#text_summary {
	width: 280px;
	margin-left: auto;
	margin-right: auto;
	text-align: left;
}

div.stat_date {
	float: left;
	padding-top: 5px;
	text-align: left;

}

div.stat_data {
	float: right;
	width: 40px;
	padding-top: 5px;
	text-align: right;
}

div.stat_max {
	float: right;
	width: 40px;
	padding: 5px 0px 0px 0px;
	text-align: right;	
	font-weight: bold;
}

div.stat_min {
	float: right;
	width: 40px;
	padding-top: 5px;
	text-align: right;
	color: #ccc;
}

p.year_ago {
	font-size: 9.5pt;
	font-family: "HelveticaNeue-Medium", Arial, sans-serif;
	text-align: left;
	line-height: 150%;
}

p.credits {
	font-size: 8pt;
font-family: "HelveticaNeue-Medium", Arial, sans-serif;
	text-align: left;
	line-height: 150%;
}
	

#status_bar {

	font-weight: lighter;
	background: rgba(255,255,255,0.1);
	position: fixed;
	top: 0;
	width: 100%;
	height: 22px;
	font-size: 23pt;
	color: <?php //echo $color; ?> white;
	/* text-shadow: 1px 1px 5px black; */
	
}

#wrap {
   	
 
    text-align: center;
    
    /* So bleibt es mittig und responsive */
	position: absolute;
	left: 0;
	right:0;
    width: 340px;
    margin-left: auto;
    margin-right: auto;

    color: <?php // echo $color; ?> white;
    z-index: 1;
    display: block;
    background: rgba(0,0,0,0.6);
    padding: 0px 0px 0px 0px;
    box-shadow: 0px 0px 5px black;
    
    -webkit-animation: fadein;
    -webkit-animation-duration: 1s; 
	-webkit-animation-timing-function: ease-in;
	
}

@-webkit-keyframes fadein {
    from { opacity: 0; }
    to   { opacity: 1; }
}

/* Für iPhone */
@media (max-device-width: 700px) {
	div#wrap {
	width: 100%;
	}
	
	div.degree {
		visibility: hidden;
	}
	
	div#passed_time {
	<?php
#Nur pulsieren, wenn es aktuell ist
if ($pulsation != 'No') {
	echo '-webkit-animation: pulsate 2s ease-out;
    -webkit-animation-iteration-count: infinite; 
    
    opacity: 0.0;';
};	
	?>
	}
}


p.date {
	float: left;
	padding:10px 0px 0px 22px;
	margin:0;
}

p.time {
	float: right;
	padding: 10px 22px 0px 0px;
	margin:0;
}

p.time_diff {
	float:center;
	padding: 10px 22px 0px 0px;
	margin:0;
}


#img.source-image {
	
	position: absolute;
	top: 0;
	left: 0;
}

div.subheadline {
	font-size: 12pt;
	font-family: "HelveticaNeue-Medium", Arial, sans-serif;
	text-align: left;
	margin: 20px 0px 0px 0px;
	background: #000;
	opacity: 0.3;
	padding: 5px 3px 3px 3px;
	vertical-align: center;
}

div.subheadline img {
	vertical-align: middle;
	margin: 2px 2px 2px 2px;
}

div#the_past {
	/* background: rgba(255,255,255,0.5); */
	overflow: auto;
	padding: 0px 0px 5px 0px;
	width: 280px;


	font-size: 14pt;
	margin-left: auto;
	margin-right: auto;
	
	margin-top: 40px;
	display:block;
	border-top: 0px solid #fff;
	border-bottom: 0px solid #fff;
	
}

div.past_entry {
	border-bottom: 0px solid #333;
    margin-bottom: 15px;
	overflow: auto;
	display: block;
	font-size: 13pt;
}

div.past_date {
	float: left;
	text-transform: lowercase;
	
	
}

div.max_temp {
	float: right;
	width: 50px;
	font-weight: bold;
	text-align: right;
}

div.min_temp {
	float: right;
	width: 50px;
	color: #ccc;
	text-align: right;
}

h5 {
	text-align: left;
	font-size: 13pt;
	font-weight: lighter;
	margin: 20px 0px 0px 0px;
	padding:0;
	
}

hr {
	opacity: 0.3;
}

div#version_information {
	border-bottom: 1px solid #fff; 
	margin-bottom: 20px; 
	padding: 5px; 
	opacity: 0.3; 
	font-size: 10pt;
}



/* Countdown Kram. Übernommen von hier: http://zombocalyp.se/ */

.hasCountdown {
    border: none;
}
.countdown_holding span {
}
.countdown_row {
    clear: both;
    width: 100%;
    padding: 0px 2px;
    text-align: center;
}
.countdown_show1 .countdown_section {
    width: 98%;
}
.countdown_show2 .countdown_section {
    width: 48%;
}
.countdown_show3 .countdown_section {
    width: 32.5%;
}
.countdown_show4 .countdown_section {
    width: 24.5%;
}
.countdown_show5 .countdown_section {
    width: 19.5%;
}
.countdown_show6 .countdown_section {
    width: 16.25%;
}
.countdown_show7 .countdown_section {
    width: 14%;
}
.countdown_section {
    display: block;
    float: left;
    font-size: 12pt;
    text-align: center;
}
.countdown_amount {
    font-size: 34pt;
}
.countdown_descr {
    display: block;
    width: 100%;
}

#defaultCountdown {
    margin-bottom: 25px;
    
}

div#the_countdown {
	/* background: rgba(255,255,255,0.5); */
	overflow: auto;
	padding: 25px 10px 10px 10px;
	width: 300px;
	font-weight: lighter;
	font-size: 12pt;
	margin-left: auto;
	margin-right: auto;
	display:block;
	border-top: 2px solid #fff;
	border-bottom: 2px solid #fff;
	
}

