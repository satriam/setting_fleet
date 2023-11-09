<?php
$host = "localhost";
$username = "u878982223_satriam";
$password = "Sasat123#";
$dbname = "u878982223_fleet";

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn){
        die("Connection Failed:".mysqli_connect_error());
    }
    
date_default_timezone_set('Asia/Jakarta');   
?>