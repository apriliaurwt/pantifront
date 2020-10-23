<?php
	include "../../config/library.php";
   	include "../../config/fungsi_tgl.php";
	require_once "../../config/db_login.php";
	$id_kategori = $_GET['id_kategori'];

	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
		if ($db->connect_errno){
			die ("Could not connect to the database: <br />". $db->connect_error);
		}
  	mysqli_query($db, "DELETE FROM kategori WHERE id_kategori='$_GET[id_kategori]'");
	echo 'Data telah dihapus';
  	header('location:kelola_kategori.php');
?>
