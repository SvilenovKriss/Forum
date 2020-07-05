<?php
// $db = @mysqli_connect(serverName, username, password, dbname) OR die('Could not connect to MySQL'.
//  mysqli_connect_error());
$connectionInfo = "mysql:host=" . host . ";dbname=" .dbName;
$db = new PDO($connectionInfo, username, password);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
?>