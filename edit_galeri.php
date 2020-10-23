<?php
	session_start();
	include "../../config/library.php";
   	include "../../config/fungsi_tgl.php";
	//require_once "../../config/db_login.php";
include("../../config/db_login.php");
	if(!isset($_SESSION['id_admin'])){
		header('location:index.php');
	}
	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
		if ($db->connect_errno){
			die ("Could not connect to the database: <br />". $db->connect_error);
		}
	$edit = mysqli_query($db, "SELECT * FROM galeri WHERE id_galeri='$_GET[id_galeri]'");
	$data  	= mysqli_fetch_array($edit);
	$pesan = "";
	$id_galeri=$_GET['id_galeri'];
	/*if($data['filename'] != null || $data['filename'] != ''){
		$filedb=$data['filename'];
	}else{
		$filedb="";
	}

	//Buat konfigurasi upload
	//Folder tujuan upload file
	$error       = false;
	$folder     = './gambar/';
	$id_galeri = $_GET['id_galeri'];

	//type file yang bisa diupload
	$file_type  = array('jpg','jpeg','png','gif','bmp','JPG');
	//tukuran maximum file yang dapat diupload
	$max_size   = 2000000; // 2MB
	if(isset($_POST['Update'])){

		//Mulai memorises data
		$file_name  = $_FILES['data_upload']['name'];
		$file_size  = $_FILES['data_upload']['size'];

		$tmp_name = $_FILES["data_upload"]["tmp_name"];
		$nama_galeri = $_POST['nama_galeri'];
		$deskripsi = $_POST['deskripsi'];

		//cari extensi file dengan menggunakan fungsi explode
		$explode    = explode('.',$file_name);
		$extensi    = $explode[count($explode)-1];
		 //var_dump($file_name.' '.$file_size);die();
		//check apakah type file sudah sesuai
		if(!in_array($extensi,$file_type)){
			$error = true;
			echo "<script>window.alert('Type file yang Anda upload tidak sesuai');</script>";
			//$pesan .= 'Type file yang anda upload tidak sesuai<br />';
		}
		if($file_size > $max_size){
			//var_dump($file_size);die();
			$error = true;
			echo "<script>window.alert('Ukuran file melebihi batas maximum');</script>";
//$pesan .= 'Ukuran file melebihi batas maximum<br />';
		}
		//check ukuran file apakah sudah sesuai

		if($error == true){
			$tampilkanpesan = "";
			//echo '<div id="error">'.$pesan.'</div>';
		}
		else{
			//mulai memproses upload file
			if(move_uploaded_file($tmp_name, $folder.$file_name)){
				if(empty($tmp_name)){
					mysqli_query($db, "UPDATE galeri SET nama_galeri='$_POST[nama_galeri]', deskripsi='$_POST[deskripsi]' WHERE id_galeri = '$_POST[id_galeri]'");
				}else{
					$data=mysqli_fetch_array(mysqli_query($db, "SELECT filename FROM galeri where id_galeri='$_POST[id_galeri]'"));
					if($data['filename'] != "") unlink("gambar/".$data['filename']);
					//var_dump($data['filename']);die();
					move_uploaded_file($_FILES['data_upload']['tmp_name'], "gambar/".$_FILES['data_upload']['name']);
					mysqli_query($db, "UPDATE galeri SET nama_galeri='$_POST[nama_galeri]', filename='$file_name', deskripsi='$_POST[deskripsi]' WHERE id_galeri = '$_POST[id_galeri]'");
				}
			} else{
				echo "<script>window.alert('Proses upload error');</script>";
			}
			$edit = mysqli_query($db, "SELECT * FROM galeri WHERE id_galeri='$_GET[id_galeri]'");
			$data  	= mysqli_fetch_array($edit);
		}
	}*/

?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="icon" href="../../img/iconar.png" type="image/x-icon"/>
		<title><?php echo "Selamat Datang ".$_SESSION['nama']; ?></</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link id="bootstrap-style" href="../asset/css/bootstrap.min.css" rel="stylesheet">
		<link href="../asset/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link id="base-style" href="../asset/css/style.css" rel="stylesheet">
		<link id="base-style-responsive" href="../asset/css/style-responsive.css" rel="stylesheet">
		<script src="../asset/js/bootstrap.min.js" type="text/javascript"></script>
		<link href="../asset/css/menu.css" rel="stylesheet" type="text/css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
		<style>
				.error{
					color:red;
				}
				.area{
					width:100px;
				}
			</style>
	</head>
	<body>
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<a class="brand" href="../beranda.php"><span><img alt="logo panti" src="../../assets/image/logo.png" width=200px/></span></a></a>

					<!-- Menu Header -->
					<div class="nav-no-collapse header-nav">
						<ul class="nav pull-right">
							<li class="dropdown">
								<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<a class="btn dropdown-toggle" data-toggle="dropdown" data-target= "#myNavbar"><span class="icon-user"></span>
									<?php echo $_SESSION['nama']; ?><span class="caret"></span>
								</a>

								<ul class="dropdown-menu">
									<li class="dropdown-menu-title">
										<span>Pengaturan</span>
									</li>
									<li><a href="../akun/ganti_password.php"><i class="icon-lock"></i> Keamanan</a></li>
									<li><a href="../logout.php" onClick="return confirm('Apakah Anda ingin keluar ?')"><i class="icon-off"></i>Keluar</a></li>
								</ul>
							</li>
							<!-- end: User Dropdown -->
						</ul>
					</div>
					<!-- end: Header Menu -->
				</div>
			</div>
		</div>
		<!---End Navbar --->

		<!-- start: Header -->
			<div class="container-fluid-full">
				<div class="row-fluid">
					<!-- start: Main Menu -->
					<div id="sidebar-left" class="span2">
						<div class="nav-collapse sidebar-nav">
							<ul class="nav nav-tabs nav-stacked main-menu">
								<li><a href="../beranda.php"><i class="icon-home"></i><span class="hidden-tablet"> Beranda</span></a></li>
								<li><a href="../hikmah/daftar_post.php"><i class="icon-file-alt"></i><span class="hidden-tablet"></span> Kelola Berita</a></li>
								<li><a href="../kategori/kelola_kategori.php"><i class="icon-file"></i><span class="hidden-tablet"> Kelola Kategori</span></a></li>
								<li><a href="lihat_gambar.php"><i class="icon-camera"></i><span class="hidden-tablet"></span> Kelola Galeri</a></li>
								<li><a href="../pesan/tampil_pesan.php"><i class="icon-envelope"></i><span class="hidden-tablet"> Pesan Masuk</span></a></li>
								<li><a href="../akun/lihat_admin.php"><i class="icon-user"></i><span class="hidden-tablet"> User</span></a></li>
							</ul>
						</div>
					</div>
					<!-- end: Main Menu -->

					<!-- start: Content -->
					<div id="content" class="span10">
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="../beranda.php">Beranda</a>
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-edit"></i>
								<a href="#">Edit Gambar</a>
							</li>
						</ul>

						<div class="row-fluid sortable">
							<div class="box span12">
								<div class="box-header" data-original-title>
									<h2><i class="icon-edit"></i><span class="break"></span>Edit Gambar</h2>
									<div class="box-icon">
										<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
										<a href="#" class="btn-close"><i class="icon-remove"></i></a>
									</div>
								</div>

								<div class="box-content">
									<form method="POST" class="form-horizontal"  autocomplete="on" enctype="multipart/form-data" action="edit_galeri_proses.php?id_galeri=<?php echo $id_galeri;?>">
										<input type="hidden" name="id_galeri" value="<?php echo $data['id_galeri']; ?>">
										<div class="wrap" style="margin-left:100px; padding:10px;">
									<table style="width:80%;">
											<tr>
												<td>Judul Galeri</td>
												<td></td>
												<td><input type="text" id="nama_galeri" name="nama_galeri" class="span8 typeahead" required value="<?php echo $data['nama_galeri']; ?>"></td>
											</tr>

											<tr>
												<td>Ganti Gambar</td>
												<td></td>
												<td><img src="gambar/<?php echo $data['filename']; ?>" width="200" ><br /><input type="file" name="data_upload" class="form-control" >
												</td>
											</tr>
											<tr>
												<td>Deskripsi</td>
												<td></td>
												<td><textarea id="deskripsi" name="deskripsi"  rows="3" autofocus><?php echo $data['deskripsi']; ?>
												</textarea></td>
											</tr>
											<tr>
												<td colspan="2"></td>
												<td><br /><button type="submit" name="Update" id="submit" value="submit" class="btn btn-primary">Update</button>
												<!--&nbsp <button type="reset" class="btn btn-default">Reset</button>-->
												&nbsp <button type="button" class="btn btn-default" onClick="window.location.href='lihat_gambar.php'">Batal</button></td>
											</tr>
											<tr>
												<td></td>
												<td colspan="2" style="color : red;"><br/><?php echo '<div id="error">'.$pesan.'</div>';?><br/></td>
												</tr>

										</table>
									</div>
									</form>
								</div>
							</div>
						</div>

					</div>
					<!---End : Content--->

		<!-- start: JavaScript-->
		<script src="../asset/js/jquery-1.9.1.min.js"></script>
		<script src="../asset/js/jquery-migrate-1.0.0.min.js"></script>
		<script src="../asset/js/jquery-ui-1.10.0.custom.min.js"></script>
		<script src="../asset/js/jquery.ui.touch-punch.js"></script>
		<script src="../asset/js/modernizr.js"></script>
		<script src="../asset/js/bootstrap.min.js"></script>
		<script src='../asset/js/fullcalendar.min.js'></script>
		<script src='../asset/js/jquery.dataTables.min.js'></script>
		<script src="../asset/js/excanvas.js"></script>
		<script src="../asset/js/jquery.flot.js"></script>
		<script src="../asset/js/jquery.flot.pie.js"></script>
		<script src="../asset/js/jquery.flot.stack.js"></script>
		<script src="../asset/js/jquery.flot.resize.min.js"></script>
		<script src="../asset/js/jquery.chosen.min.js"></script>
		<script src="../asset/js/jquery.uniform.min.js"></script>
		<script src="../asset/js/jquery.cleditor.min.js"></script>
		<script src="../asset/js/jquery.noty.js"></script>
		<script src="../asset/js/jquery.elfinder.min.js"></script>
		<script src="../asset/js/jquery.raty.min.js"></script>
		<script src="../asset/js/jquery.iphone.toggle.js"></script>
		<script src="../asset/js/jquery.uploadify-3.1.min.js"></script>
		<script src="../asset/js/jquery.gritter.min.js"></script>
		<script src="../asset/js/jquery.imagesloaded.js"></script>
		<script src="../asset/js/jquery.masonry.min.js"></script>
		<script src="../asset/js/jquery.knob.modified.js"></script>
		<script src="../asset/js/jquery.sparkline.min.js"></script>
		<script src="../asset/js/counter.js"></script>
		<script src="../asset/js/retina.js"></script>
		<script src="../asset/js/custom.js"></script>
		<!-- end: JavaScript-->
	</body>
</html>
<?php
	$db->close();
?>
