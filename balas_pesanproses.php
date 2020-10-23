<?php
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	include "../../config/library.php";
   	include "../../config/fungsi_tgl.php";
	require_once "../../config/db_login.php";
	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
	if ($db->connect_errno){
		die ("Could not connect to the database: <br />". $db->connect_error);
	}
	$balas = $_POST['balas'];
	$id_tamu = $_POST['id_tamu'];
	$balas = test_input($balas);

	if(EMPTY($balas) || $balas == " " || $balas=="" || $balas ==null){
		echo "<script>window.alert('Pesan gagal');
			window.location='detail_pesan.php?id_tamu=$id_tamu'</script>";
	}else{
		mysqli_query($db, "UPDATE tamu SET balas='$balas' WHERE id_tamu = '$id_tamu'");
		echo "<script>window.alert('Pesan telah terkirim');
			window.location='tampil_pesan.php'</script>";
	}

	//echo"<meta http-equiv='refresh' content='1; url=tampil_pesan.php'>";
?>

<!--@mail($to, $subjek, $pesan, $header);
echo "Pesan Berhasil Dikirim";
	header('location:tampil_pesan.php');
	}
-->
