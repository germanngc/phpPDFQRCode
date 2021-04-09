<?php
require_once dirname(__FILE__) . '/config/config.php';
require_once dirname(__FILE__) . '/config/login.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$phpPDFQRLogin::doLogin($_POST['username'], $_POST['password']);
}

$pageTitle = "Inicio de Sesión";

include dirname(__FILE__) . '/views/body.php';
?> 
<main class="container" style="max-width: 600px;">
	<?php $phpPDFQRConfig::flashGet(); ?> 

	<div class="d-flex align-items-center p-3 my-3 text-white bg-labsal rounded shadow-sm">
		<div class="lh-1">
			<h1 class="h5 mb-1 text-white lh-1">zogen | Laboratorio Salazar</h1>
			<small>Administrador de Pruebas SARS-CoV-2 (COVID 19)</small>
		</div>
	</div>

	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<h6 class="pb-2 mb-2 text-center">Iniciar Sessión</h6>

		<form action="<?php echo $phpPDFQRConfig::$rootURL; ?>/login.php" method="POST">
			<div class="form-group mb-4">
				<label for="username" class="sr-only form-label">Usuario:</label>
				<input type="email" name="username" id="username" class="form-control" placeholder="correo@ejemplo.com" required>
			</div>

			<div class="form-group mb-4">
				<label for="password" class="sr-only form-label">Contraseña:</label>
				<input type="password" name="password" id="password" class="form-control" placeholder="contraseña" required>
			</div>

			<div class="form-group mb-4">
				<div class="d-grid gap-2">
					<input type="submit" name="submit" class="btn btn-labsal btn-lg btn-block" value="Iniciar">
				</div>
			</div>
		</form>
	</div>
</main>

<?php include dirname(__FILE__) . '/views/footer.php'; ?> 
