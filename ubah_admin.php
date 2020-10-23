<!DOCTYPE HTML>
<?php
	session_start();
	//login database
	require_once('../../config/db_login.php');

	$id = $_GET['id'];
	//connecting to database
	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
	if($db->connect_errno){
		die("Could not connect to database: <br />".$db->connect_error);
	}

	if($_SESSION['username']){
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
			function checkPass(){
				//Store the password field objects into variables ...
				var pass1 = document.getElementById('password');
				var pass2 = document.getElementById('password2');
				//Store the Confimation Message Object ...
				var message = document.getElementById('confirmMessage');
				//Set the colors we will be using ...
				var goodColor = "#66cc66";
				var badColor = "#ff6666";
				//Compare the values in the password field
				//and the confirmation field
				if(pass1.value == pass2.value){
					//The passwords match.
					//Set the color to the good color and inform
					//the user that they have entered the correct password
					pass2.style.backgroundColor = goodColor;
					message.style.color = goodColor;
					message.innerHTML = "Password Match!"
				}else{
					//The passwords do not match.
					//Set the color to the bad color and
					//notify the user.
					pass2.style.backgroundColor = badColor;
					message.style.color = badColor;
					message.innerHTML = "Password Do Not Match!"
				}
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
	<?php } ?>
		<!-- start: Header -->

		<div class="container-fluid-full">
			<div class="row-fluid">

				<!-- start: Main Menu -->
				<div id="sidebar-left" class="span2">
					<div class="nav-collapse sidebar-nav">
						<ul class="nav nav-tabs nav-stacked main-menu">
							<li><a href="../beranda.php"><i class="icon-home"></i><span class="hidden-tablet"> Beranda</span></a></li>
							<li class="dropdown">
								<a class="dropmenu"><i class="icon-edit"></i><span class="hidden-tablet"> Kelola Berita </span><span class="caret"></span></a>
								<ul>
									<li><a class="daftar_post" href="../hikmah/daftar_post.php"><i class="icon-file-alt"></i><span class="hidden-tablet"></span><small> Daftar Posting</small></a></li>
								</ul>
							</li>
							<li><a href="../kategori/kelola_kategori.php"><i class="icon-file"></i><span class="hidden-tablet"> Kelola Kategori</span></a></li>
							<li class="dropdown">
								<a class="dropmenu"><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> Kelola Galeri</span><span class="caret"></span></a>
								<ul>
									<li><a class="submenu" href="../galeri/lihat_gambar.php"><i class="icon-camera"></i><span class="hidden-tablet"></span><small> Lihat Gambar</small></a></li>
								</ul>
							</li>
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
							<i class="icon-config"></i>
							<a href="#">Pengaturan Profil</a>
						</li>
					</ul>

					<!--/.nav-collapse -->
					<div class="container">
												<?php
							// define variables
							if(!isset($_POST["submit"])){
								$query = "SELECT * FROM admin WHERE id_admin = '$id'";
								$result = $db->query($query);
								if(!$result){
								}else{
									while($row = $result->fetch_object()){
										$username = $row->username;
										$nama = $row->nama;
									}
								}
							}else{			
								$username = $_POST['username'];
								$nama = $_POST['nama'];
								$username = test_input($_POST["username"]);
								// check if name value is valid
								if(empty($_POST["username"])){
									$usernameErr = "Username tidak boleh kosong";
									$validusername = FALSE;
								}else{
									$validusername = TRUE;
								}
								
								$nama = test_input($_POST["nama"]);
								// check if name value is valid
								if(empty($_POST["nama"])){
									$namaErr = "Nama tidak boleh kosong";
									$validnama = FALSE;
								}elseif(!preg_match("/^[a-zA-Z ]*$/",$nama)){
									$namaErr = "Nama hanya boleh menggunakan huruf dan spasi"; 
									$validnama = FALSE;
								}else{
									$validnama = TRUE;
								}
								
								
								//insert if all values are valid
								if($validusername && $validnama){
									//clearing input data
									$username = $db->real_escape_string($_POST['username']);
									$nama = $db->real_escape_string($_POST['nama']);
									$query = "UPDATE `admin` SET `username`='$username', `nama`='$nama' WHERE id_admin = '$id'";
									$result = $db->query($query);
									if(!$result){
										die("Could not query the database <br />".$db->error);
									}
									else{
										$_SESSION['username'] = $username;
										$_SESSION['nama'] = $nama;
										echo "<script>window.alert('Data berhasil diperbarui');
		window.location='lihat_admin.php'</script>";
										//$notice = 'Data berhasil diperbarui';
									}
								}
							}

							function test_input($data) {
							   $data = trim($data);
							   $data = stripslashes($data);
							   $data = htmlspecialchars($data);
							   return $data;
							}
						?>

						<div class="row-fluid sortable">
									<?php
									//	if(isset($_SESSION['notifikasipassword'])){
									//		echo $_SESSION['notifikasipassword'];
									//		unset ($_SESSION['notifikasipassword']);
										//}
									?>
									<div class="box span10">
										<div class="box-header" data-original-title>
											<h2><i class="halflings-icon edit"></i><span class="break"></span>Ubah Profile Admin</h2>
											<div class="box-icon">
												<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
											</div>
										</div>
										<div class="box-content">
											<form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id=<?php echo $id;?>">
											  <fieldset>
												<div class="control-group">
												  <label class="control-label" for="typeahead"> Username </label>
												  <div class="controls">
													<input type="text" class="span6 typeahead" id="username" name="username" value="<?php echo $username;?>" data-provide="typeahead" data-items="4" required>
												  </div>
												  <span class="error" valign="top"> <?php if(isset($usernameErr)) echo $usernameErr;?></span>
												</div>

												<div class="control-group">
												  <label class="control-label" for="typeahead"> Nama </label>
												  <div class="controls">
													<input type="text" class="span6 typeahead" id="nama" name="nama" value="<?php echo $nama;?>" data-provide="typeahead" data-items="4" required>
												  </div>
												<span class="error" valign="top"> <?php if(isset($namaErr)) echo $namaErr;?></span>
												</div>

												<div class="form-actions">
												  <button type="submit" name="submit" value="submit" class="btn btn-primary">Simpan</button>
												  &nbsp <button type="button" class="btn btn-default" onClick="window.location.href='../beranda.php'">Batal</button></td>
												</div>
											  </fieldset>
											</form>
										</div>
									</div><!--/span-->
								</div><!--/row-->
							</body>
							<p>
							<?php
								if(isset($notice)) echo $notice;
							?>
						</p>
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
