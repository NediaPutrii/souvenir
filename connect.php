<?php
	$host = "webgis.mysql.database.azure.com";
	$user = "mysql@webgis";
	$pass = "#12345678Webgis";
	$dbname = "souvenir";
	$conn = mysqli_connect($host, $user, $pass, $dbname) or die("Gagal");

	// $host = "localhost";
	// $user = "root";
	// $pass = "root";
	// $dbname = "abcde";
	// $conn = mysqli_connect($host, $user, $pass, $dbname) or die("Gagal");

	// $con=mysqli_init(); 
	// mysqli_real_connect($con, "webgis.mysql.database.azure.com", "mysql@webgis", "#12345678Webgis" , "souvenir" , 3306);
 ?>
