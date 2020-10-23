<?php
	include "../../config/library.php";
   	include "../../config/fungsi_tgl.php";
	require_once "../../config/db_login.php";

	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
		if ($db->connect_errno){
			die ("Could not connect to the database: <br />". $db->connect_error);
		}
	$data=mysqli_fetch_array(mysqli_query($db, "SELECT gambar FROM berita WHERE id_berita='$_GET[id_berita]'"));
  	if($data['gambar'] != "") unlink("../upload/$data[gambar]");
  	mysqli_query($db, "DELETE FROM berita where id_berita='$_GET[id_berita]'");
  	header('location:daftar_post.php');
?>
