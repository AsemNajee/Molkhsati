<?php

$host = 'localhost';
$username = 'root';
$password = '';
$db = 'the_database_name';

$conn = mysqli_connect($host, $username, $password, $db);
if(!$conn){
   exit;
}


?>