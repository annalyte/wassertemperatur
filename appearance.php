

body {
    font-family: "SanFranciscoDisplay-Regular", "Roboto", "HelveticaNeue-UltraLight", "AvenirNext-UltraLight", Arial, sans-serif;
  /*  background: url(bg_summer.png) center top no-repeat #231301;
    background-size: 100%; */
    background-color: #000;
    padding:0;
    margin:0;
   /* background-color: <?php echo $color; ?>; */
    
    -webkit-font-smoothing: antialiased;

	
/*	
	text-shadow: -0px 2px 2px #868686; */
}

div.background_image_container {
	background: url(image_store/<?php echo $bg_image; ?>) no-repeat top center fixed;
	background-size: cover;
	background-color: #000;
	min-height: 100%;
	width: 100%;
	z-index: -1;
	position: absolute;
	-webkit-filter: blur(10px);
	opacity: 0.8;
}

video#videobcg {
  position: absolute; bottom: 0px; right: 0px; min-width: 100%; min-height: 100%; width: auto; height: auto; z-index: -1000; overflow: hidden;
}



div.today {
    font-size: 80pt;
    padding:30px 0px 0px 0px;
    font-weight: 100;
    /* text-shadow: 2px 2px 0px #333333; */
    letter-spacing: -8px;
    
    margin:0px 0px 0px -25px;
    color:<?php //echo $color; ?> white;
    /*
    -webkit-mask-image: -webkit-gradient(linear, left top,
    left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0.7))); */
}

div.degree {
	font-family: "San Francisco Display", "Roboto", "HelveticaNeue-Light";
	position: absolute;
	font-size: 60px;
	top: 35px;
	left: 238px;
	
}

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

h2 {
    font-size: 32pt;
    font-family: "SanFranciscoDisplay-Regular", "Roboto", "HelveticaNeue-Light";
	font-weight: lighter;
    /* text-shadow: 2px 2px 0px #333333; */

    color: <?php //echo $color; ?> white;
    
}

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
	font-size: 13pt;
	font-family: "San Francisco Display", "Roboto", "HelveticaNeue-Medium";
	
}

p.version {
    font-size: 8pt;
    margin-top: 110px;
}

p.year_ago {
	font-size: 11pt;
	font-family: "San Francisco Display", "Roboto", "HelveticaNeue-Medium";
	text-align: justify;
	line-height: 20px;
}

#status_bar {
	font-family: "San Francisco Display", "Roboto", "HelveticaNeue-Light";
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
   
    height: auto;
/*	background: rgba(255,255,255,0.9); */
 /*   -webkit-mask-image: -webkit-gradient(linear, left top,
    left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0.7))); */
    text-align: center;
    min-height: 100%;
    width: 320px;
    margin-left: auto;
    margin-right: auto;
    color: <?php // echo $color; ?> white;
    z-index: 1;
    position: relative;
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
	text-align: left;
	margin: 20px 0px 0px 0px;
	background: #000;
	opacity: 0.3;
	padding: 3px;
}

div#the_past {
	/* background: rgba(255,255,255,0.5); */
	overflow: auto;
	padding: 0px 0px 5px 0px;
	width: 280px;
	font-family: "SanFranciscoDisplay-Regular", "Roboto", "HelveticaNeue-Light";

	font-size: 16pt;
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
}

div.past_date {
	float: left;
	text-transform: uppercase;
	
	
}

div.past_temp {
	float: right;
}

h5 {
	text-align: left;
	font-size: 16pt;
	font-weight: lighter;
	
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
	font-family: "San Francisco Display", "Roboto", "HelveticaNeue-Light";
	font-weight: lighter;
	font-size: 12pt;
	margin-left: auto;
	margin-right: auto;
	display:block;
	border-top: 2px solid #fff;
	border-bottom: 2px solid #fff;
	
}

