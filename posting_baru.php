<?php
	session_start();
	//include("../../config/db_login.php");
	if(!isset($_SESSION['id_admin'])){
		header('location:index.php');
	}
	date_default_timezone_set("Asia/Jakarta");
	$today = date("F j, Y, g:i a");
	include "../../config/library.php";
   	include "../../config/fungsi_tgl.php";
	require_once "../../config/db_login.php";

	global $db;
	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
		if ($db->connect_errno){
			die ("Could not connect to the database: <br />". $db->connect_error);
		}

	if(isset($_POST["submit"])){

		$nama_gambar 	= $_FILES['fupload']['name'];
		$lokasi_gambar 	= $_FILES['fupload']['tmp_name'];
		$tipe_gambar	= $_FILES['fupload']['type'];

		$judul = test_input($_POST['judul']);
			if ($judul == ''){
				$error_judul = "Judul harus diisi";
				$valid_judul = FALSE;
			}else{
				$valid_judul = TRUE;
			}

		$kategori = test_input($_POST['kategori']);
		if (EMPTY ($kategori) || $kategori == '' || $kategori == ' ' || $kategori == null){
			$error_kategori = "Kategori harus diisi";
			$valid_kategori = FALSE;
		}else{
			$valid_kategori = TRUE;
		}

		$headline = test_input($_POST['headline']);
		if (EMPTY ($headline) || $headline == '' || $headline == ' ' || $headline == null){
			$error_headline = "Headline harus diisi";
			$valid_headline = FALSE;
		}else{
			$valid_headline = TRUE;
		}

		$konten = test_input($_POST['konten']);
		if (EMPTY($konten) || $konten == '' || $konten == ' ' || $konten == null || $konten == '&lt;br&gt;'){
			$error_konten = "Konten is required";
			$valid_konten = FALSE;
		}else{
			$valid_konten = TRUE;
		}


		//update data into database
		$cek_judul = "SELECT * FROM berita WHERE judul='$_POST[judul]'";
        $proses_cek = mysqli_query($db, $cek_judul);
        $cek2 = mysqli_fetch_assoc($proses_cek);

		if( !empty($cek2)){
			echo '<script> alert ("Judul Berita sudah ada"); </script>';
			echo("<META HTTP-EQUIV=Refresh CONTENT=\"0.1;URL=posting_baru.php\">");
		}else{

			//escape inputs data
			$judul = $db->real_escape_string($judul);
			$kategori = $db->real_escape_string($kategori);
			$headline = $db->real_escape_string($headline);
			$konten = $db->real_escape_string($konten);

			if(empty($lokasi_gambar)){
				$query = "INSERT INTO berita (judul, id_kategori, headline, konten_berita,  hari, tgl, jam)
				VALUES ('$judul', '$kategori', '$headline', '$konten', '$hari_ini', '$tgl_sekarang', '$jam_sekarang')";
				mysqli_query($db, $query);
				echo"Data telah tersimpan";
				sleep(2);
				header("location:daftar_post.php");
			}else{
				//move_uploaded_file($lokasi_gambar,"../upload/berita/$nama_gambar");
				move_uploaded_file($_FILES['fupload']['tmp_name'], "../upload/".$_FILES['fupload']['name']);
				$query = "INSERT INTO berita (judul, id_kategori, headline, konten_berita,gambar, hari, tgl, jam)
				VALUES ('$judul', '$kategori', '$headline', '$konten', '$nama_gambar','$hari_ini', '$tgl_sekarang', '$jam_sekarang')";
				mysqli_query($db, $query);
				echo"Data telah tersimpan";
				sleep(2);
				header("location:daftar_post.php");
			}

				$db->close();
				exit;

		}
	}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>
<!DOCTYPE HTML>
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
		<script type="text/javascript" src="../asset/js/nicEdit-latest.js"></script>
		<script> bkLib.onDomLoaded(function() { nicEditors.allTextAreas() }); </script>
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
								<li><a href="daftar_post.php"><i class="icon-file-alt"></i><span class="hidden-tablet"></span> Kelola Berita</a></li>
								<li><a href="../kategori/kelola_kategori.php"><i class="icon-file"></i><span class="hidden-tablet"> Kelola Kategori</span></a></li>
								<li><a href="../galeri/lihat_gambar.php"><i class="icon-camera"></i><span class="hidden-tablet"></span> Kelola Galeri</a></li>
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
								<a href="#">Tambah Berita</a>
							</li>
						</ul>

						<div class="row-fluid sortable">
							<div class="box span12">
								<div class="box-header" data-original-title>
									<h2><i class="icon-edit"></i><span class="break"></span>Tambah Berita</h2>
									<div class="box-icon">
										<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
										<a href="#" class="btn-close"><i class="icon-remove"></i></a>
									</div>
								</div>

								<div class="box-content">
									<form method="POST" class="form-horizontal"  autocomplete="on" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
										<div class="wrap" style="margin-left:100px; padding:10px;">
									<table style="width:80%;">

											<tr>
												<td>Judul</td>
												<td></td>
												<td><input type="text" id="judul" name="judul" class="span8 typeahead" value="<?php if(isset($judul)){echo $judul;} ?>" autofocus ></td>
												<td><span class="error">* <?php if(isset($error_judul)){echo $error_judul;}?></span></td>
											</tr>

											<tr>
												<td>Kategori</td>
												<td></td>
												<td><select name="kategori" class="span6 typeahead" required>
													<option value ="0">-- Pilih Kategori --</option>
													<?php
														$query = "SELECT * FROM kategori ORDER BY nama_kategori";
														$hasil = mysqli_query($db, $query);
														while($r=mysqli_fetch_array($hasil)){
															echo "<option value=\"$r[id_kategori]\">$r[nama_kategori]</option>";
														}
													?>
												</select>
												</td>
												<td><span class="error">* <?php if(isset($error_kategori)){echo $error_kategori;}?></span></td>

											</tr>

											<tr>
												<td>Headline</td>
												<td></td>
												<td><select name="headline" class="span4 typeahead" required>
														<option value ="N"> No Headline</option>
														<option value ="Y"> Headline</option>
												</select>
												</td>
												<td><span class="error">* <?php if(isset($error_headline)){echo $error_headline;}?></span></td>

											</tr>

											<tr>
												<td>Konten Berita</td>
												<td></td>
												<td><textarea name="konten"  rows="15" style='width: 720px; height: 350px;'><?php if(isset($konten)){echo $konten;}?></textarea></td>
												<td valign="top"><span class="error">* <?php if(isset($error_konten)){echo $error_konten;}?></span></td>
											</tr>

											<tr>
												<td>Unggah Gambar</td>
												<td></td>
												<td><input type="file" name="fupload" class="form-control" required="required" >
												</td>
											</tr>

											<tr>
												<td colspan="2"></td>
												<td><button type="submit" name="submit" id="submit" value="submit" class="btn btn-primary">Publish</button>
												&nbsp <button type="button" class="btn btn-default" onClick="window.location.href='daftar_post.php'">Batal</button></td>
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
