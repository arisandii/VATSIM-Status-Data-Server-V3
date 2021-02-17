<?php 

$uri = "";
$user = "";
$pass = "";
$db = "";

$con = mysqli_connect($uri, $user, $pass);
if(!$con){
  die("Cannot make connection to database.");
}
$seldb = mysqli_select_db($con, $db);
if(!$seldb){
  die("Cannot find any database.");
}

?>
