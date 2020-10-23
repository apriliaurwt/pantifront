<?php
	session_start();
	include("../../config/db_login.php");
	if(!isset($_SESSION['id_admin'])){
		header('location:index.php');
	}
	require_once('../../config/db_login.php');
	$message='';
	$db = new mysqli($db_host,$db_username,$db_password,$db_database);  //koneksi ke database
	$nama				= $_SESSION['nama'];
	$currentPassword  	= '';
	$newPassword 	 	= '';
	$confirmPassword	= '';
	if(isset($_POST['submit'])){
		$currentPassword  	= md5($_POST['currentPassword']);
		$newPassword 	 	= md5($_POST['newPassword']);
		$confirmPassword	= md5($_POST['confirmPassword']);
		$currentPassword  	= filter($currentPassword);
		$newPassword 		= filter($newPassword);
		$confirmPassword	= filter($confirmPassword);
		if($db->connect_errno){
			die ("could not connect to the database: <br />".$db->connect_error);
		}
		$query 	= "SELECT * FROM admin where nama ='$nama'";
		$result = $db->query($query);
		while($row = $result->fetch_object()){
			$password = $row->password;
		}
		if($currentPassword == $password) {
			$query2 = "UPDATE admin set password='" . $newPassword . "' WHERE nama='" . $nama . "'";
			$result2 = $db->query($query2);
			if(!$result2){
				$message = "Current Password is not correct";
			}else{
				echo "<script>window.alert('Password changed'); window.location='../beranda.php'</script>";
				//$message = "Password Changed";
			}
		}else{
			$message = "Current Password is not correct";
		}
	}
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="icon" href="../../assets/image/iconar.png" type="image/x-icon"/>
		<title><?php echo "Selamat Datang ".$_SESSION['nama']; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link id="bootstrap-style" href="../asset/css/bootstrap.min.css" rel="stylesheet">
		<link href="../asset/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link id="base-style" href="../asset/css/style.css" rel="stylesheet">
		<link id="base-style-responsive" href="../asset/css/style-responsive.css" rel="stylesheet">
		<script src="../asset/js/bootstrap.min.js" type="text/javascript"></script>
		<link href="../asset/css/menu.css" rel="stylesheet" type="text/css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
		<!-- end: CSS -->
		<script>
			function validatePassword() {
			var currentPassword,newPassword,confirmPassword,output = true;

			currentPassword = document.frmChange.currentPassword;
			newPassword = document.frmChange.newPassword;
			confirmPassword = document.frmChange.confirmPassword;

			if(!currentPassword.value) {
				currentPassword.focus();
				document.getElementById("currentPassword").innerHTML = " required";
				output = false;
			}
			else if(!newPassword.value) {
				newPassword.focus();
				document.getElementById("newPassword").innerHTML = " required";
				output = false;
			}
			else if(!confirmPassword.value) {
				confirmPassword.focus();
				document.getElementById("confirmPassword").innerHTML = " required";
				output = false;
			}
			if(newPassword.value != confirmPassword.value) {
				newPassword.value="";
				confirmPassword.value="";
				newPassword.focus();
				document.getElementById("confirmPassword").innerHTML = "not same";
				output = false;
			}
			return output;
			}
		</script>
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
					<a class="brand" href="../beranda.php"><span><img alt="logo panti" src="../../assets/image/logo.png" width=200px/></span></a>

					<!-- Menu Header -->
					<div class="nav-no-collapse header-nav">
						<ul class="nav pull-right">
							<li class="dropdown">
								<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<a class="btn dropdown-toggle" data-toggle="dropdown" data-target= "#myNavbar"><span class="icon-user"></span><?php echo $_SESSION['nama']; ?>
										<span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li class="dropdown-menu-title">
										<span>Pengaturan</span>
									</li>
									<li><a href="ganti_password.php"><i class="icon-lock"></i> Keamanan</a></li>
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
							<li><a href="../galeri/lihat_gambar.php"><i class="icon-camera"></i><span class="hidden-tablet"></span> Kelola Galeri</a></li>
							<li><a href="../pesan/tampil_pesan.php"><i class="icon-envelope"></i><span class="hidden-tablet"> Pesan Masuk</span></a></li>
							<li><a href="lihat_admin.php"><i class="icon-user"></i><span class="hidden-tablet"> User</span></a></li>
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
							<i class="icon-user"></i>
							<a href="#">Keamanan Akun</a>
						</li>
					</ul>
					<div class="box span10">
						<div class="box-header" data-original-title>
							<h2><i class="icon-lock"></i><span class="break"></span>Form Ganti Password</h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							</div>
						</div>
						<form name="frmChange" method="post" action="" onSubmit="return validatePassword()">
							<div style="width:500px;">
								<div class="message"><?php if(isset($message)) { echo $message; } ?></div>
								<table border="0" cellpadding="10" cellspacing="0" width="500" align="center" class="tblSaveForm">
									<tr>
										<td width="40%"><label>Password Lama</label></td>
										<td width="60%"><input type="password" name="currentPassword" class="txtField"/><span id="currentPassword"  class="required"></span></td>
									</tr>
									<tr>
										<td><label>Password Baru</label></td>
										<td><input type="password" name="newPassword" class="txtField"/><span id="newPassword" class="required"></span></td>
									</tr>
									<tr>
										<td><label>Konfirmasi Password Baru</label></td>
										<td><input type="password" name="confirmPassword" class="txtField"/><span id="confirmPassword" class="required"></span></td>
									</tr>
									<tr>
										<td colspan="2"><input type="submit" name="submit" value="Submit" class="btn btn-primary">
										&nbsp <button type="button" class="btn btn-default" onClick="window.location.href='../beranda.php'">Batal</button></td>
									</tr>
								</table>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<footer>
			<p>
				<span style="text-align:left;float:left">&copy; 2017 Ar-Rodiyah Semarang</a></span>
			</p>
		</footer>

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
