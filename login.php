<?php
require_once dirname(__FILE__) . '/config/config.php';
require_once dirname(__FILE__) . '/config/login.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$phpPDFQRLogin::doLogin($_POST['username'], $_POST['password']);
}

$pageTitle = "Inicio de Sesión // Login";

include dirname(__FILE__) . '/views/body.php';
?> 
<main class="container" style="max-width: 600px;">
	<?php $phpPDFQRConfig::flashGet(); ?> 

	<div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
		<div class="lh-1">
			<h1 class="h6 mb-1 text-white lh-1">Zogen | Laborario Salazar</h1>
			<small>Administrador de Pruebas SARS COVID 19</small>
		</div>
	</div>

	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<h6 class="border-bottom pb-2 mb-0 text-center">Iniciar Sessión</h6>

		<form action="<?php echo $phpPDFQRConfig::$rootURL; ?>/login.php" method="POST">
			<div class="form-group mb-2">
				<label for="username" class="">Usuario // Username:</label><br>
				<input type="email" name="username" id="username" class="form-control">
			</div>

			<div class="form-group mb-2">
				<label for="password" class="">Contraseña // Password:</label><br>
				<input type="password" name="password" id="password" class="form-control">
			</div>

			<div class="form-group mb-2">
				<input type="submit" name="submit" class="btn btn-primary btn-lg btn-block" value="Enviar // Submit">
			</div>
		</form>
	</div>
</main>

<?php include dirname(__FILE__) . '/views/footer.php'; ?> 
