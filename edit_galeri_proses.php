<?php
	include "../../config/library.php";
   	include "../../config/fungsi_tgl.php";
	require_once "../../config/db_login.php";
	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
	if ($db->connect_errno){
		die ("Could not connect to the database: <br />". $db->connect_error);
	}

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	$error=false;

	$nama_galeri = $_POST['nama_galeri'];
	$deskripsi = $_POST['deskripsi'];

	$nama_galeri = test_input($nama_galeri);
	$deskripsi = test_input($deskripsi);
	$id_galeri = $_GET['id_galeri'];
	if($_FILES['data_upload']['name'] != "" || $_FILES['data_upload']['name'] != null){
		//tukuran maximum file yang dapat diupload
		$max_size   = 2000000; // 2MB

		$file_name 	= $_FILES['data_upload']['name'];
		$file_size  = $_FILES['data_upload']['size'];
		$file_type  = array('jpg','jpeg','png','gif','bmp','JPG');
		$tmp_name 	= $_FILES['data_upload']['tmp_name'];
		$tipe_gambar	= $_FILES['data_upload']['type'];

		//cari extensi file dengan menggunakan fungsi explode
		$explode    = explode('.',$file_name);
		$extensi    = $explode[count($explode)-1];

		//check apakah type file sudah sesuai
		if(!in_array($extensi,$file_type)){
			$error = true;
			echo "<script>window.alert('Type file yang Anda upload tidak sesuai');window.location='edit_galeri.php?id_galeri=$id_galeri'</script>";
			//$pesan .= 'Type file yang anda upload tidak sesuai<br />';
		}
		if($file_size > $max_size || $file_size == 0){
			$error = true;
			echo "<script>window.alert('Ukuran file melebihi batas maximum');window.location='edit_galeri.php?id_galeri=$id_galeri'</script>";
			//$pesan .= 'Ukuran file melebihi batas maximum<br />';
		}
		//check ukuran file apakah sudah sesuai

		if($error == true){
			$tampilkanpesan = "";
			//echo '<div id="error">'.$pesan.'</div>';
			//header('location:edit_galeri.php?id_galeri='.$id_galeri);
		}
		else{
			if(empty($tmp_name)){
				mysqli_query($db, "UPDATE galeri SET nama_galeri='$nama_galeri', deskripsi='$deskripsi' WHERE id_galeri='$id_galeri'");
			}else{
				$data=mysqli_fetch_array(mysqli_query($db, "SELECT filename FROM galeri where id_galeri='$_POST[id_galeri]'"));
				//var_dump($data['filename']);die();
				if($data['filename'] != "") unlink("gambar/$data[filename]");

				move_uploaded_file($_FILES['data_upload']['tmp_name'], "gambar/".$_FILES['data_upload']['name']);
				mysqli_query($db, "UPDATE galeri SET nama_galeri='$_POST[nama_galeri]', filename='$file_name', deskripsi='$_POST[deskripsi]' WHERE id_galeri = '$id_galeri'");
			}
			echo "<script>window.alert('Data telah diedit'); window.location='lihat_gambar.php'</script>";
		}
	}else{
		mysqli_query($db, "UPDATE galeri SET nama_galeri='$_POST[nama_galeri]', deskripsi='$_POST[deskripsi]' WHERE id_galeri = '$id_galeri'");
		echo "<script>window.alert('Data telah diedit');window.location='lihat_gambar.php'</script>";
	}
?>
