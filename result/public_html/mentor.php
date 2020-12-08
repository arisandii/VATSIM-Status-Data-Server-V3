<?php

# Function to solve inability
# to use file_get_contents
function url_get_contents ($Url) {
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
    $mentorData = "https://idvacc.id/data/wiif-mentor.json";
    $data = json_decode(url_get_contents($mentorData), true);
    
    if (array_key_exists($_GET['cid'], $data)) {
        die("TRUE");
    } else {
        die("FALSE");
    }
} else {
    echo "Missing parameter.";
}

?>