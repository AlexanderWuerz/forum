<?php
// connect.php

$server = "localhost";
$username = "user";
$password = "pasword";
$database = "wikipedia_db"; 
// $database = "rough_forum_db"; 
// Connect to server and select databse.

$connection=mysqli_connect("$server", "$username", "$password")or die("cannot connect"); 
mysqli_select_db($connection,"$database")or die("cannot select DB");

/*
if (!mysql_connect($server, $username, $password)) 
	exit('Error: could not connect to database '+$database); 
if (!mysql_select_db($database)) 
	exit('Error: could nto select database '+$database);  
print("Connection Established!"); 
*/

?>
