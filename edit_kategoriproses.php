<?php
	include "../../config/library.php";
   	include "../../config/fungsi_tgl.php";
	require_once "../../config/db_login.php";
	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
	if ($db->connect_errno){
		die ("Could not connect to the database: <br />". $db->connect_error);
	}

	$namakategori2 =$_POST['nama_kategori'];
	$cek = "SELECT * FROM kategori WHERE nama_kategori='$namakategori2'";
	$hasilproses = $db->query($cek);
	$totaldata = $hasilproses->num_rows;
	if ($totaldata > 0){
		echo "<script>window.alert('Kategori yang anda masukan sudah ada');
		window.location='kelola_kategori.php'</script>";
		}else {
		mysqli_query($db, "UPDATE kategori SET nama_kategori='$_POST[nama_kategori]' WHERE id_kategori = '$_POST[id_kategori]'");
	}

//	mysqli_query($db, "UPDATE kategori SET nama_kategori='$_POST[nama_kategori]' WHERE id_kategori = '$_POST[id_kategori]'");
	echo "<script>window.alert('Data telah diedit');
		window.location='kelola_kategori.php'</script>";
//	header('location:kelola_kategori.php');

?>
