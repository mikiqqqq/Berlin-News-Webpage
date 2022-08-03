<?php
$dbc = mysqli_init();
mysqli_ssl_set($dbc,NULL,NULL, "certificate/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect($dbc, "berlin-news-server.mysql.database.azure.com", "berlin_news_mng", "Admin-BZ$&3", "berlin-news-database", 3306, MYSQLI_CLIENT_SSL)
or die('Error connecting to MySQL server.'.mysqli_error());
// Create connection
mysqli_set_charset($dbc, "utf8");
?>
