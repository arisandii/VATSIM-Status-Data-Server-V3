<?php 

$uri = "103.129.221.31";
$user = "idvaccid_data";
$pass = "59N%aebtaVXT";
$db = "idvaccid_data";

$con = mysqli_connect($uri, $user, $pass);
if(!$con){
  die("Cannot make connection to database.");
}
$seldb = mysqli_select_db($con, $db);
if(!$seldb){
  die("Cannot find any database.");
}

?>