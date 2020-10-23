<?php
	session_start();
	include("../../config/db_login.php");
	if(!isset($_SESSION['id_admin'])){
		header('location:index.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="icon" href="../../img/iconar.png" type="image/x-icon"/>
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
					<a class="brand" href="../beranda.php"><span></a>

					<!-- Menu Header -->
					<div class="nav-no-collapse header-nav">
						<ul class="nav pull-right">
							<li class="dropdown">
								<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<a class="btn dropdown-toggle" data-toggle="dropdown" data-target= "#myNavbar"><span class="icon-user"></span>
								 <?php echo $_SESSION['nama']; ?><span class="caret"></span></a>
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

		<!-- start: Header -->

		<div class="container-fluid-full">
			<div class="row-fluid">
				<!-- start: Main Menu -->
				<div id="sidebar-left" class="span2">
					<div class="nav-collapse sidebar-nav">
						<ul class="nav nav-tabs nav-stacked main-menu">
							<li><a href="../beranda.php"><i class="icon-home"></i><span class="hidden-tablet"> Beranda</span></a></li>
							<li class="dropdown">
								<a class="dropmenu"><i class="icon-edit"></i><span class="hidden-tablet"> Posting Berita </span><span class="caret" ></span></a>
								<ul>
									<li><a class="daftar_post" href="../hikmah/daftar_post.php"><i class="icon-file-alt"></i><span class="hidden-tablet"> Daftar Posting</span></a></li>
									<li><a class="posting_baru" href="../hikmah/posting_baru.php"><i class="icon-file-alt"></i><span class="hidden-tablet"> Posting Baru</span></a></li>

								</ul>
							</li>
							<li><a href="../kategori/kelola_kategori.php"><i class="icon-file"></i><span class="hidden-tablet"> Kelola Kategori</span></a></li>
							<li class="dropdown">
								<a class="dropmenu" ><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> Galeri</span><span class="caret" ></span></a>
								<ul>
									<li><a class="submenu" href="upload_gambar.php"><i class="icon-upload"></i><span class="hidden-tablet"> Upload Gambar</span></a></li>
									<li><a class="submenu" href="lihat_gambar.php"><i class="icon-camera"></i><span class="hidden-tablet"> Lihat Gambar</span></a></li>
									<li><a class="submenu" href="galeri.php"><i class="icon-picture"></i><span class="hidden-tablet"> Galeri</span></a></li>
								</ul>
							</li>
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
							<a href="../beranda.php">Home</a>
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<i class="icon-picture"></i>
							<a href="galeri.php">Galeri</a>
						</li>
					</ul>
					<div class="row-fluid sortable">
						<div class="box span12">
							<div class="box-header" data-original-title>
								<h2><i class="icon-picture"></i><span class="break"></span> Galeri</h2>
									<div class="box-icon">
										<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
										<a href="#" class="btn-close"><i class="icon-remove"></i></a>
									</div>
							</div>

							<div class="box-content">
								<div id="gambar" class="masonry-thumb">
										<?php
											$db = mysqli_connect("localhost", "root", "", "db_arrodiyah");

											$query = "SELECT * FROM galeri";
											$tampil = mysqli_query($db, $query);

											$kolom=4;

											echo "<table><tr>";
											$i=0;
											while($r=mysqli_fetch_array($tampil)){
												if($i>=$kolom){
													echo "</tr></tr>";
													$i=0;
												}
												$i++;

												echo"<td colspan='2' align=\"center\" style=\"padding:30px\"><br>
													<a href=\"gambar/$r[filename]\" title=$r[filename]><img src=\"gambar/$r[filename]\" width=\"200px\" height=\"200px\">
													<br></a><br>$r[nama_galeri]<br>
													</td>";
											}
											echo "</tr></table>"
										?>
								</div>
							</div>
						</div>
					</div>
				</div><!--/.fluid-container-->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->

		<div class="clearfix"></div>
		<footer>
			<p>
				<span style="text-align:left;float:left">&copy; 2017 Ar-Rodiyah Semarang - Powered by Informatika UNDIP</a></span>
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
