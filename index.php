<?php
require_once dirname(__FILE__) . '/config/config.php';

$pageTitle = "Dashboard";

include dirname(__FILE__) . '/views/body.php';
?> 
<main class="container">
	<?php $phpPDFQRConfig::flashGet(); ?> 

	<div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
		<div class="lh-1">
			<h1 class="h6 mb-1 text-white lh-1">Zogen | Laborario Salazar</h1>
			<small>Administrador de Pruebas SARS COVID 19</small>
		</div>
	</div>

	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<h6 class="border-bottom pb-2 mb-0">Ultimos Registros</h6>

		<?php
$sql = "SELECT * FROM covid_tests ORDER BY created_at DESC LIMIT 10;";
$results = mysqli_query($phpPDFQRConfig::$con, $sql);

while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
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
					<strong class="text-gray-dark"><?php echo $row['first_name'] . ' ' . $row['last_name'] . ' Villa #' . $row['villa']; ?></strong>
					<div>
						<?php if ($row["test_date_taken"]): ?> 
						<button type="button" class="btn btn-primary"
							onclick="window.open('<?php echo $phpPDFQRConfig::$rootURL; ?>/pdf-generate.php?itemId=<?php echo $row['id']; ?>', '_blank');">
							Ver PDF
						</button>
						<button type="button" class="btn btn-primary"
							onclick="javascript:void(0);">
							Enviar Email
						</button>
						<?php endif; ?> 
						<button type="button" class="btn btn-primary"
							onclick="location.href = '<?php echo $phpPDFQRConfig::$rootURL; ?>/form-edit.php?id=<?php echo $row['id']; ?>';">
							Editar
						</button>
					</div>
				</div>
				<span class="d-block">Tipo de Test: <?php echo $row["test_type"]; ?> / Fecha de Salida: <?php echo $row["departuredate"]; ?> </span>
			</div>
		</div>
		<?php
}

// Free result set
mysqli_free_result($results);
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
