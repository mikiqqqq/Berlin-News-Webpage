<?php
$servername = "localhost";
$username = "root";
$password = "";
$basename = "bz";

// Create connection
$dbc = mysqli_connect($servername, $username, $password, $basename) or die('Error
connecting to MySQL server.'.mysqli_error());
mysqli_set_charset($dbc, "utf8");
?>
