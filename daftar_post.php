<?php
	session_start();
	if(!isset($_SESSION['id_admin'])){
		header('location:index.php');
	}
	date_default_timezone_set("Asia/Jakarta");
	$today = date("F j, Y, g:i a");

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
		<script>
		function confirmdelete(delUrl) {
		   if (confirm("Anda yakin ingin menghapus?")) {
		      document.location = delUrl;
		   }
		}
</script>
	<style type="text/css">
			th{
				background-color : #008B8B;
				color : white;
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
							<a href="#">Post</a>
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<i class="icon-file"></i>
							<a href="#">Posting Berita</a>
						</li>
					</ul>
					<!---Konten Tabel ---->
					<h1>Data Posting Berita</h1>
					<hr>
					<p><a href="posting_baru.php"><img src = "../img/tambah1.png"> Tambah Berita </a></p>
					<br>
						<table class="table table-bordered">
							<tr>
								<th>No</th>
								<th>Judul</th>
								<th>Kategori</th>
								<th>Headline</th>
								<th>Hari</th>
								<th>Tanggal</th>
								<th colspan="2">Kelola</th>
							</tr>
							<link href="../asset/css/style_pagging.css" rel="stylesheet" type="text/css">
							<?php
								// connect database
								require_once('../../config/db_login.php');
								$db = new mysqli($db_host, $db_username, $db_password, $db_database);
								if ($db->connect_errno){
									die ("Could not connect to the database: <br />". $db->connect_error);
								}
								$batas   = 5;
								$halaman = @$_GET['halaman'];
								if(empty($halaman)){
									$posisi  = 0;
									$halaman = 1;
								}
								else{
								  $posisi  = ($halaman-1) * $batas;
								}

								//Asign a query
								$query = " SELECT id_berita, judul, nama_kategori, headline, konten_berita, gambar, hari, tgl FROM berita b INNER JOIN kategori k
								ON b.id_kategori = k.id_kategori ORDER BY tgl DESC LIMIT $posisi,$batas ";
								// Execute the query
								$result = $db->query( $query );
								if (!$result){
									die ("Could not query the database: <br />". $db->error);
								}
								// Fetch and display the results
								$i = $posisi+1;
								while ($row = $result->fetch_object()){
									echo '<tr>';
									echo '<td>'.$i.'</td>';
									echo '<td>'.$row->judul.'</td> ';
									echo '<td>'.$row->nama_kategori.'</td> ';
									echo '<td>'.$row->headline.'</td>';
									echo '<td>'.$row->hari.'</td>';
									echo '<td>'.$row->tgl.'</td>';
									echo '<td>
											<a href="edit_post.php?id_berita='.$row ->id_berita.'"><img src="../img/edit.png"></a> </td>';
									?>
									<td>
											<a href="<?php echo "hapus_post.php?id_berita=$row->id_berita";?>" onclick="return confirm('Anda Yakin ingin Menghapus Data Tersebut?')"><img src="../img/delete.png"></a>
									</td>
									<?php
									echo '</tr>';
									$i++;
								}
									echo '</table>';
									echo '<br />';
									//hitung total data dan halaman serta link 1,2,3
									$query2     = mysqli_query($db, "SELECT id_berita, judul, nama_kategori, headline, konten_berita, gambar, hari, tgl FROM berita b INNER JOIN kategori k
								ON b.id_kategori = k.id_kategori ORDER BY id_berita");
									$jmldata    = mysqli_num_rows($query2);
									$jmlhalaman = ceil($jmldata/$batas);

									$file = $_SERVER['PHP_SELF'];
									echo "<div class=\"pagging\">";
									if($halaman > 1){
										$prev=$halaman-1;
										echo "<span class=\"prevnext\">
										<a href=\"$file?halaman=$prev\"><< Prev </span>";
									}else{
										echo "<span class=disabled><< Prev</span>";
									}

									for($n=1;$n<=$jmlhalaman;$n++)
										if ($n != $halaman){
											echo " <a href=\"daftar_post.php?halaman=$n\">$n</a> ";
										}
										else{
											echo " <span class=\"current\">$n</span> ";
										}

									if($halaman < $jmlhalaman){
										$next=$halaman+1;
										echo "<span class=\"prevnext\">
										<a href=\"$file?halaman=$next\">Next >></span>";
									}else{
										echo " <span class=\"disabled\">Next >></span> ";
									}

									echo "</div>";
									echo 'Total Rows = '.$result->num_rows;
									$result->free();
									$db->close();
							?>
						</table>
				</div><!--/.fluid-container-->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->

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
