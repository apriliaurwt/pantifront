<?php
include('../../config/db_login.php');
$id_galeri = $_GET['id_galeri'];
$db = new mysqli($db_host,$db_username,$db_password,$db_database);  //koneksi ke database
	if($db->connect_errno){
		die ("could not connect to the database: <br />".$db->connect_error);
	}
	//delete data into database
	//escape inputs data
	//Assign a query
	$data=mysqli_fetch_array(mysqli_query($db, "SELECT * FROM galeri where id_galeri='$_GET[id_galeri]'"));
	if($data['filename'] != "") unlink("gambar/$data[filename]");
	$query=mysqli_query($db, "DELETE from  galeri where id_galeri='$_GET[id_galeri]'");

	echo("<META HTTP-EQUIV=Refresh CONTENT=\"0.1;URL=lihat_gambar.php\">");
?>
