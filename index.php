<?php
	session_start();
	include("../config/db_login.php");
	if (isset($_POST["submit"])){
		$username = test_input($_POST['username']);
		if ($username == ''){
		$error_username = "Username harus diisi";
		$valid_username = FALSE;
		}else{
		$valid_username = TRUE;
	}
	$password = md5(test_input($_POST['password']));
	if ($password == ''){
		$error_password = "Password harus diisi";
		$valid_password = FALSE;
	}elseif (!preg_match("/^[a-z0-9]*$/",$password)) {
		$error_password = "Hanya huruf dan angka yang diperbolehkan";
		$valid_password = FALSE;
	}else{
		$valid_password = TRUE;
	}
	if ($valid_username && $valid_password){
		$db = new mysqli($db_host, $db_username, $db_password, $db_database);
		if ($db->connect_errno){
			die ("Could not connect to the database: <br />".$db->connect_error);
		}
		$username = $db->real_escape_string($username);//memprotect username
		$password1 = $db->real_escape_string($password);//memprotect password
		$query = "SELECT * FROM admin WHERE username = '" .$username. "' and password = '".$password1."'";//mencocokkan username password
		$result = $db->query($query);
		if(!$result){
			die ("Could not query the database; <br />".$db->error);
		}else{
		while ($row = $result->fetch_object()){
			$_SESSION['username'] = $row->username;
			$_SESSION['nama'] = $row->nama;
			$_SESSION['id_admin'] = $row->id_admin;
		}
			header('Location: index.php?error=1');
		}
		if(isset($_SESSION["username"])) {
			header("Location:beranda.php");
			exit();
		}
	}
	//close db connection
	$db->close();
}
	function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="icon" href="../assets/image/iconar.png" type="image/x-icon"/>
		<title>LOGIN ADMIN</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link id="bootstrap-style" href="../css/bootstrap.min.css" rel="stylesheet">
		<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
		<link id="base-style" href="../css/inistyle.css" rel="stylesheet">
		<link id="base-style" href="../css/login.css" rel="stylesheet">
		<link id="base-style-responsive" href="../css/inistyle-responsive.css" rel="stylesheet">
		<script src="../js/bootstrap.min.js" type="text/javascript"></script>
		<link href="../css/menu.css" rel="stylesheet" type="text/css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
		<!-- end: CSS -->
	</head>
	<body>
			<div class="container">
		    <div class="row">
		        <div class="col-sm-6 col-md-4 col-md-offset-4">
		            <h2 class="text-center login-title" style="margin-top:100px">SILAHKAN LOGIN</h2>
		            <div class="login-box-body" style="text-align:center">
		                <img class="profile-img" src="../assets/image/login-icon.png" alt="profile">
		                <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		                	<?php
									if (isset($_GET['error']) AND !empty($_GET['error']))
									{
										echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> <center> Username/ password incorrect </center></div>';
									}
								?>
						<div class="form-group has-feedback" style="margin-top:20px">
		                <input type="text" class="form-control" placeholder="Nama Pengguna" name="username" id="username" required autofocus>
		                </div>
		                <div class="form-group has-feedback">
		                <input type="password" class="form-control" name="password" id="password" placeholder="Kata Sandi" required>
		                </div>
		                <div class="button-login text-center">
							<button type="submit" name="submit" class="btn btn-primary" value="Login">Login</button>
							<input type="reset" name="reset" class="btn btn-default" value="Reset" />
						</div>
						<div class="clearfix"></div>
		                </form>
		            </div>
		            <div class="clearfix"></div>
		        </div>
		    </div>
		</div>
	

		<nav class="navbar navbar-inverse navbar-fixed-bottom" style="color : #ffffff; padding-top:15px; ">
		<div class="container-fluid">

			<p align="left"><i> &copy 2017 Ar-rodiyah Semarang</i> <br /></p>
			</div>
		</nav>


		<!-- start: JavaScript-->
		<script src="../js/jquery-1.9.1.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<!-- end: JavaScript-->
	</body>
</html>
