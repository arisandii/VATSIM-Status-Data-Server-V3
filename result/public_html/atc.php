<?php

require("function.get-data.php");

if(isset($_GET['callsign'])){
	print(searchATC($_GET['callsign']));
} else {
	echo ("Uh, I missed a parameter. I cannot proccess your request :(.<br/>
	Please set the ICAO you're requesting by following example below:<br/>
	<a href=\"http://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ."?callsign=WA\">http://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ."?callsign=WA</a>.<br/><br/>
	
	You can also set 2 or more parameter to get more data too!<br/>
	<a href=\"http://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ."?callsign=WA,WI\">http://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ."?callsign=WA,WI</a>.");
}

?>
