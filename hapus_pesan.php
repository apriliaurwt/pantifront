<?php
	include "../../config/library.php";
   	include "../../config/fungsi_tgl.php";
	require_once "../../config/db_login.php";
	$id_tamu = $_GET['id_tamu'];

	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
		if ($db->connect_errno){
			die ("Could not connect to the database: <br />". $db->connect_error);
		}
  	mysqli_query($db, "DELETE FROM tamu where id_tamu='$_GET[id_tamu]'");
  	header('location:tampil_pesan.php');
?>
