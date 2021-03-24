<?php
require_once dirname(__FILE__) . '/config/config.php';
require_once dirname(__FILE__) . '/config/login.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$phpPDFQRLogin::doLogin($_POST['username'], $_POST['password']);
}
?><html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
	<meta name="title" content="Zogen Generate PDF - by Nina Code">
	<meta name="author" content="Nina Code">
	<meta name="theme-color" content="#7952b3">

	<title>Zogen Generate PDF - by Nina Code</title>

	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<!-- Custom styles for this template -->
	<link href="/assets/style.css" rel="stylesheet">
</head>

<body class="bg-light">
	<?php include dirname(__FILE__) . '/views/header.php'; ?> 

	<main class="container" style="max-width: 600px;">
		<?php $phpPDFQRConfig::flashGet(); ?> 

		<div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
			<div class="lh-1">
				<h1 class="h6 mb-0 text-white lh-1">Zogen | Laborario Salazar</h1>
				<small>Administrador de Pruebas SARS COVID 19</small>
			</div>
		</div>

		<div class="my-3 p-3 bg-body rounded shadow-sm">
			<h6 class="border-bottom pb-2 mb-0 text-center">Iniciar Sessión</h6>

			<form action="<?php echo $phpPDFQRConfig::$rootURL; ?>/login.php" method="POST">
				<div class="form-group mb-2">
					<label for="username" class="">Username:</label><br>
					<input type="text" name="username" id="username" class="form-control">
				</div>

				<div class="form-group mb-2">
					<label for="password" class="">Password:</label><br>
					<input type="password" name="password" id="password" class="form-control">
				</div>

				<div class="form-group mb-2">
					<input type="submit" name="submit" class="btn btn-primary btn-lg btn-block" value="submit">
				</div>
			</form>
		</div>
	</main>

	<!-- JavaScript Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>