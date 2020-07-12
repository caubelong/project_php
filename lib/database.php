<?php

use http\Header;

$dbServer="localhost";
$dbUser="root";
$dbPass="";
$dbName="project1";
$db=mysqli_connect($dbServer,$dbUser,$dbPass,$dbName);
function dedirec_to($location){
    header("location:".$location);
    exit;
}
session_start();
?>
