<?php

# Function to solve inability
# to use file_get_contents
function url_get_contents($Url) {
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

if(isset($_GET['cid'])){
	$linktocheck = "https://hq.vatme.net/api/member/approved/" . $_GET['cid'];
    $userstatus = url_get_contents($linktocheck);
    $data = json_decode($userstatus, true);
	
    foreach ($data as $data){ 
	    if (($data["vacc"] == 'WIIF') and ($data["approved_for"] != '') and ($data["approved_for"] != null)){
	        print("TRUE");
	    }
    }
} else {
	print("Insufficient parameter set. Please fix URL requested.");
}

?>
