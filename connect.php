<?php
	$host = "webgis.mysql.database.azure.com";
	$user = "mysql@webgis";
	$pass = "#12345678Webgis";
	$dbname = "sys";
	$conn = mysqli_connect($host, $user, $pass, $dbname) or die("Gagal");
?>