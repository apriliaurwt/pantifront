<?php
	include "../../config/library.php";
   	include "../../config/fungsi_tgl.php";
	require_once "../../config/db_login.php";
	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
		if ($db->connect_errno){
			die ("Could not connect to the database: <br />". $db->connect_error);
		}


	$nama_gambar 	= $_FILES['fupload']['name'];
	$lokasi_gambar 	= $_FILES['fupload']['tmp_name'];
	$tipe_gambar	= $_FILES['fupload']['type'];

	if(empty($lokasi_gambar)){
		mysqli_query($db, "UPDATE berita SET judul='$_POST[judul]', id_kategori='$_POST[kategori]', headline='$_POST[headline]', konten_berita='$_POST[konten]', hari='$hari_ini', tgl='$tgl_sekarang', jam='$jam_sekarang' WHERE id_berita = '$_POST[id_berita]'");

	}else{
		$data=mysqli_fetch_array(mysqli_query($db, "SELECT gambar FROM berita where id_berita='$_POST[id_berita]'"));
		if($data['gambar'] != "") unlink("../upload/$data[gambar]");

		move_uploaded_file($_FILES['fupload']['tmp_name'], "../upload/".$_FILES['fupload']['name']);
		mysqli_query($db, "UPDATE berita SET judul='$_POST[judul]', id_kategori='$_POST[kategori]', headline='$_POST[headline]', konten_berita='$_POST[konten]', gambar='$nama_gambar', hari='$hari_ini', tgl='$tgl_sekarang', jam='$jam_sekarang' WHERE id_berita = '$_POST[id_berita]'");
	}

	echo "<script>window.alert('Data telah diedit');
			window.location='daftar_post.php'</script>";
?>
