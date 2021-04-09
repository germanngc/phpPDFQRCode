<?php
require_once dirname(__FILE__) . '/config/config.php';
require_once dirname(__FILE__) . '/config/users.php';

$pageTitle = "Usuarios";

include dirname(__FILE__) . '/views/body.php';
?> 
<main class="container">
	<?php $phpPDFQRConfig::flashGet(); ?> 

	<div class="d-flex align-items-center p-3 my-3 bg-labsal text-labsal rounded shadow-sm">
		<div class="lh-1">
			<h1 class="h2 mb-1 text-white lh-1">zogen | Laboratorio Salazar</h1>
			<small>Administrador de Pruebas SARS-CoV-2 (COVID 19)</small>
		</div>
	</div>

	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<h6 class="border-bottom pb-2 mb-4">Usuarios</h6>

		<?php
if ($action == 'list') {
	while ($row = mysqli_fetch_array($displayData, MYSQLI_ASSOC)) {
		?><div class="d-flex text-muted pt-3">
			<svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"
				xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32"
				preserveAspectRatio="xMidYMid slice" focusable="false">
				<title>Placeholder</title>
				<rect width="100%" height="100%" fill="#007bff"/>
				<text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
			</svg>

			<div class="pb-3 mb-0 small lh-sm border-bottom w-100">
				<div class="d-flex justify-content-between">
					<strong class="text-gray-dark"><?php echo $row['username']; ?></strong>
					<div>
						<button type="button" class="btn btn-primary" onclick="location.href = '<?php echo $phpPDFQRConfig::$rootURL; ?>/users.php?action=edit&itemId=<?php echo $row['id']; ?>';">
							Editar
						</button>
						<button type="button" class="btn btn-danger" onclick="location.href = '<?php echo $phpPDFQRConfig::$rootURL; ?>/users.php?action=delete&itemId=<?php echo $row['id']; ?>';">
							Borrar
						</button>
					</div>
				</div>
				<span class="d-block">Creado en: <?php echo $row['created_at']; ?></span>
			</div>
		</div>
		<?php
	}

	// Free result set
	mysqli_free_result($displayData);
} else if ($action == 'create') {
		?><form action="<?php echo $phpPDFQRConfig::$rootURL; ?>/users.php?action=create" id="createUserForm" method="POST">
			<div class="row">
				<div class="col-md-12 mb-3">
					<label for="username" class="form-label">Usuario (email) <span class="form-required-star"></span></label>
					<input type="email" class="form-control" id="username" name="username" required>
				</div>

				<div class="col-md-6 mb-3">
					<label for="password" class="form-label">Contraseña <span class="form-required-star"></span></label>
					<input type="password" class="form-control" id="password" name="password" required>
				</div>

				<div class="col-md-6 mb-3">
					<label for="password_confirm" class="form-label">Confirmar contraseña <span class="form-required-star"></span></label>
					<input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
				</div>
			</div>

			<button type="submit" class="btn btn-primary btn-lg btn-block mb-3">Crear</button>
		</form>
		<?php
} else if ($action == 'edit') {
	?><form action="<?php echo $phpPDFQRConfig::$rootURL; ?>/users.php?action=update&itemId=<?php echo $displayData['id']; ?>" id="createUserForm" method="POST">
		<div class="row">
			<div class="col-md-12 mb-3">
				<label for="username" class="form-label">Usuario (email) <span class="form-required-star"></span></label>
				<input type="email" class="form-control" id="username" name="username" value="<?php echo $displayData['username']; ?>" disabled>
			</div>

			<div class="col-md-6 mb-3">
				<label for="password" class="form-label">Contraseña <span class="form-required-star"></span></label>
				<input type="password" class="form-control" id="password" name="password" required>
			</div>

			<div class="col-md-6 mb-3">
				<label for="password_confirm" class="form-label">Confirmar contraseña <span class="form-required-star"></span></label>
				<input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
			</div>
		</div>

		<input type="hidden" name="id" value="<?php echo $displayData['id']; ?>">

		<button type="submit" class="btn btn-primary btn-lg btn-block mb-3">Actualizar</button>
	</form>
	<?php
}
		?> 
	</div>
</main>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<div class="modal-body"></div>

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>

<?php include dirname(__FILE__) . '/views/footer.php'; ?> 
