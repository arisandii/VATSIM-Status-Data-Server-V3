<?php

require("function.get-data.php");

if(isset($_GET['callsign'])){
	print(searchPilot($_GET['callsign']));
} else {
	echo ("Uh, I missed a parameter. I cannot proccess your request :(.<br/>
	Please set the callsign you're requesting by following example below:<br/>
	<a href=\"http://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ."?icao=GIA001\">http://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ."?callsign=GIA001</a>.");
}

?>
