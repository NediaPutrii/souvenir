<?php
require '../connect.php';
$info = $_GET["info"];
$querysearch ="select id, name, address, cp,ktp,marriage_book,star, ST_X(ST_Centroid(geom)) AS lng, ST_Y(ST_CENTROID(geom)) As lat from hotel where id='$info'";	   
$hasil=mysqli_query($conn, $querysearch);
while($row = mysqli_fetch_array($hasil))
	{
		  $id=$row['id'];
		  $name=$row['name'];
		  $address=$row['address'];
		  $cp=$row['cp'];
		  $ktp=$row['ktp'];
		  $marriage_book=$row['marriage_book'];
		  $star=$row['star'];
		 
		  $longitude=$row['lng'];
		  $latitude=$row['lat'];
		  $dataarray[]=array('id'=>$id,'name'=>$name,'address'=>$address,'cp'=>$cp, 'ktp'=>$ktp, 'marriage_book'=>$marriage_book, 'star'=>$star, 'longitude'=>$longitude,'latitude'=>$latitude);
	}
echo json_encode ($dataarray);
?>
