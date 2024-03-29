<?php
define('VAR1', true);

include_once 'class.user.php';

sessionStart($app);

if (empty($_SESSION[$app['name'].'Token'])) {
    $_SESSION[$app['name'].'Token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION[$app['name'].'Token'];

if(loginCheck($DB_con) == true)
{
	header('Location: /');
	exit();
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<meta name="csrf-token" content="<?=$csrfToken?>">
        <title>Giriş - <?=$app['siteName']?></title>
        <link rel="icon" href="img/favicon.png" type="image/x-icon">
		<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
		<link href="plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="plugins/node-waves/waves.min.css" rel="stylesheet" />
		<link href="plugins/animate-css/animate.min.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet">
	</head>
	<body class="login-page bg-<?=$app['themeColor']?>">
		<div class="page-loader-wrapper">
			<div class="loader">
				<div class="preloader">
					<div class="spinner-layer pl-<?=$app['themeColor']?>">
						<div class="circle-clipper left">
							<div class="circle"></div>
						</div>
						<div class="circle-clipper right">
							<div class="circle"></div>
						</div>
					</div>
				</div>
				<p>Yükleniyor...</p>
			</div>
		</div>
		<div class="overlay"></div>
		<div class="login-box">
			<div class="logo">
				<a href="javascript:void(0);">Yönetici<b>Paneli</b></a>
			</div>
			<div class="card">
				<div class="body">
					<form id="loginForm" role="form" action="" method="post" enctype="multipart/form-data">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="material-icons">person</i>
							</span>
							<div class="form-line">
								<input type="text" class="form-control" id="username" name="username" placeholder="Kullanıcı adı" autofocus>
							</div>
						</div>
						<div class="input-group">
							<span class="input-group-addon">
								<i class="material-icons">lock</i>
							</span>
							<div class="form-line">
								<input type="password" class="form-control" id="password" name="password" placeholder="Şifre">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12" style="margin-bottom:0px!important;">
								<button class="btn btn-block bg-<?=$app['themeColor']?> waves-effect loginButton" type="submit">Giriş Yap</button>
							</div>
						</div>
					</form>
				</div>
				<div id="result"></div>
			</div>
		</div>
		<script src="plugins/jquery/jquery.min.js"></script>
		<script src="plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="plugins/node-waves/waves.min.js"></script>
		<script src="js/login.js"></script>
	</body>
</html>