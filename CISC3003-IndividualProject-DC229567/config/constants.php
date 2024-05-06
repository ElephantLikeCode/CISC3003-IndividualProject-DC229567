<?php
//Start Session
session_start();

//Create Constants to Store Non Repeating Values
define('SITEURL', 'http://localhost/cisc3003/CISC3003-IndividualProjectWS-2024/CISC3003-IndividualProject-DC229567/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'sqHinL_2003717');
define('DB_NAME', 'food-order');


$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error()); //Database Connection
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

?>