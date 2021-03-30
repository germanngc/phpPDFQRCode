<?php
require_once dirname(__FILE__) . '/config/config.php';

$pageTitle = "Dashboard";

include dirname(__FILE__) . '/views/body.php';
?> 
<style>
	.dataTables_wrapper .dt-buttons {
		margin-bottom: .75rem;
	}

	button.dt-button.buttons-bulk-emails {

	}
</style>

<main class="container-fluid">
	<?php $phpPDFQRConfig::flashGet(); ?> 

	<div class="d-flex align-items-center p-3 my-3 mb-0 bg-labsal text-labsal rounded shadow-sm">
		<div class="lh-1">
			<h1 class="h2 mb-1 lh-3">zogen | Laboratorio Salazar</h1>
			<small>Administrador de Pruebas SARS-CoV-2 (COVID 19)</small>
		</div>
	</div>

	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<table id="myTable" class="dataTable stripe nowrap order-column" data-order='[[ 4, "desc" ]]' style="font-size: 1rem; width: 100%">
			<thead>
				<tr>
					<th><input id="dataTableChecker" type="checkbox"></th>
					<th><i class="far fa-file-pdf"></i></th>
					<th><i class="fas fa-envelope-open-text"></i></th>
					<th><i class="fas fa-edit"></i></th>
					<th>File</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Birth date</th>
					<th>Sex</th>
					<th>Passport</th>
					<th>Reservation number</th>
					<th>Villa</th>
					<th>Symptoms</th>
					<th>Book type</th>
					<th>Book family</th>
					<th>Test type</th>
					<th>Patient Day Number</th>
					<th>Test date taken</th>
					<th>Test date result</th>
					<th>Test result</th>
					<th>Test reference</th>
					<th>Test sample</th>
					<th>Test method</th>
					<th>RT-PCR Observations</th>
					<th>RT-PCR Observations Reference</th>
					<th>RT-PCR Interpretation</th>
					<th>Created at</th>
					<th>Updated at</th>
				</tr>
			</thead>
		</table>
	</div>
</main>

<!-- Modal -->
<div class="modal fade" id="bulkPDFModal" tabindex="-1" aria-labelledby="bulkPDFModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<div class="modal-body"></div>

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		let bulkPDFModal = new bootstrap.Modal(document.getElementById('bulkPDFModal'), {
			keyboard: false
		});

		let buttonCommon = {
			exportOptions: {
				format: {
					body: function (data, row, column, node) {
						if (column == 9) {
							data = data.replace(/<br\>/g, '');
						}

						return data;
					}
				}
			}
		};

		document
			.getElementById("dataTableChecker")
			.addEventListener("change", function() {
				let inputs = $('.dataTable td.select-checkbox input[type=checkbox]'),
					isChecked = this.checked;

				inputs.each(function(i, o) {
					if (o.disabled) return;
					$(o).prop('checked', isChecked);
				});
			});

		$('.dataTable').DataTable({
			pageLength: 100,
			autoWidth: 'false',
			processing: true,
			serverSide: true,
			ajax: {
				url: "<?php echo $phpPDFQRConfig::$rootURL; ?>/apis/api.php?action=getForms",
				type: "post",
				dataSrc: function (json) {
					if (!json._status) {
						$('#bulkPDFModal').find('.modal-title').attr('class', 'modal-title text-danger');
						$('#bulkPDFModal').find('.modal-title').html('<i class="fas fa-bug"></i> Error');
						$('#bulkPDFModal').find('.modal-footer').html('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>');
						$('#bulkPDFModal').find('.modal-body').html(json._message);
						bulkPDFModal.show();
					}

					return json.data;
				},
				error: function() {
					$('#bulkPDFModal').find('.modal-title').attr('class', 'modal-title text-danger');
					$('#bulkPDFModal').find('.modal-title').html('<i class="fas fa-bug"></i> Error');
					$('#bulkPDFModal').find('.modal-footer').html('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>');
					$('#bulkPDFModal').find('.modal-body').html('Ocurrio un error inesperado al cargar la lista, contactar con soporte.');
					bulkPDFModal.show();
				}
			},
			scrollX: 'true',
			dom: 'Bfrtip',
			responsive: true,
			columnDefs: [{
				orderable: false,
				className: 'select-checkbox',
				targets: [0]
			},{
				orderable: false,
				targets: [1, 2, 3]
			}],
			buttons: [
				$.extend(true, {}, buttonCommon, {
					extend: 'excelHtml5',
					text: 'Exportar a Excel',
					className: 'btn',
					exportOptions: {
						columns: [4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28]
					}
				}),
				{
					text: 'Generar paquete de PDFs',
					className: 'buttons-bulk-pdf btn btn-labsal',
					action: function(e, dt, node, config) {
						$('.loading').show();
						let selected = $('.dataTable td.select-checkbox input[type=checkbox]:checked');

						if (selected.length <= 0) {
							$('#bulkPDFModal').find('.modal-title').attr('class', 'modal-title text-warning');
							$('#bulkPDFModal').find('.modal-title').html('<i class="fas fa-exclamation-triangle"></i> Advertencia');
							$('#bulkPDFModal').find('.modal-body').html('Debe seleccionar al menos un checkox en la lista para ejecutar esta función.');
							$('.loading').hide();
							bulkPDFModal.show();
							return;
						}

						let data = [];

						selected.each(function(i, o) {
							data.push(o.value);
						});

						$.ajax({
							url: '<?php echo $phpPDFQRConfig::$rootURL; ?>/apis/api.php?action=bulkPDF',
							data: {itemsId: data},
							method: 'POST',
							success: function(result, status, xhr) {
								$('.loading').hide();

								if (result.response) {
									$('#bulkPDFModal').find('.modal-title').attr('class', 'modal-title text-success');
									$('#bulkPDFModal').find('.modal-title').html('<i class="fas fa-check-circle"></i> Generado Correctamente');
									$('#bulkPDFModal').find('.modal-footer').html('<a class="btn btn-success" href="' + result.filename + '">Descargar</a> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>');
									$('#bulkPDFModal').find('.modal-body').html(result.message);
									bulkPDFModal.show();
								} else {
									$('#bulkPDFModal').find('.modal-title').attr('class', 'modal-title text-danger');
									$('#bulkPDFModal').find('.modal-title').html('<i class="fas fa-bug"></i> Error');
									$('#bulkPDFModal').find('.modal-footer').html('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>');
									$('#bulkPDFModal').find('.modal-body').html(result.message);
									bulkPDFModal.show();
								}
							},
							error: function(xhr, status, error) {
								$('.loading').hide();

								$('#bulkPDFModal').find('.modal-title').attr('class', 'modal-title text-danger');
								$('#bulkPDFModal').find('.modal-title').html('<i class="fas fa-bug"></i> Error');
								$('#bulkPDFModal').find('.modal-footer').html('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>');
								$('#bulkPDFModal').find('.modal-body').html('Ocurrio un error inesperado, contactar con soporte.');
								bulkPDFModal.show();
							}
						});
					}
				},
				{
					text: 'Envio Masivo de Correos',
					className: 'buttons-bulk-emails btn btn-labsal',
					action: function(e, dt, node, config) {
						$('.loading').show();
						let selected = $('.dataTable td.select-checkbox input[type=checkbox]:checked');

						if (selected.length <= 0) {
							$('#bulkPDFModal').find('.modal-title').attr('class', 'modal-title text-warning');
							$('#bulkPDFModal').find('.modal-title').html('<i class="fas fa-exclamation-triangle"></i> Advertencia');
							$('#bulkPDFModal').find('.modal-body').html('Debe seleccionar al menos un checkox en la lista para ejecutar esta función.');
							$('.loading').hide();
							bulkPDFModal.show();
							return;
						}

						let data = [];

						selected.each(function(i, o) {
							data.push(o.value);
						});

						sendEmailFunction(data);
					}
				}
			]
		});

		$('body').on('click', '.sendEmail', function(e) {
			$('.loading').show();

			let itemsId = [$(this).data('id')];

			sendEmailFunction(itemsId);
		});

		function sendEmailFunction(itemsId)
		{
			$.ajax({
				url: '<?php echo $phpPDFQRConfig::$rootURL; ?>/apis/api.php?action=bulkEmail',
				data: {itemsId},
				method: 'POST',
				success: function(result, status, xhr) {
					$('.loading').hide();

					if (result.response) {
						if (result.data_err.length > 0) {
							$('#bulkPDFModal').find('.modal-title').attr('class', 'modal-title text-warning');
							$('#bulkPDFModal').find('.modal-title').html('<i class="fas fa-check-circle"></i> Algunos Enviado Correctamente');
						} else {
							$('#bulkPDFModal').find('.modal-title').attr('class', 'modal-title text-success');
							$('#bulkPDFModal').find('.modal-title').html('<i class="fas fa-check-circle"></i> Enviado Correctamente');
						}

						$('#bulkPDFModal').find('.modal-footer').html('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>');
						$('#bulkPDFModal').find('.modal-body').html(result.message);
						
						bulkPDFModal.show();
					} else {
						$('#bulkPDFModal').find('.modal-title').attr('class', 'modal-title text-danger');
						$('#bulkPDFModal').find('.modal-title').html('<i class="fas fa-bug"></i> Error');
						$('#bulkPDFModal').find('.modal-footer').html('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>');
						$('#bulkPDFModal').find('.modal-body').html(result.message);
						bulkPDFModal.show();
					}
				},
				error: function(xhr, status, error) {
					$('.loading').hide();

					$('#bulkPDFModal').find('.modal-title').attr('class', 'modal-title text-danger');
					$('#bulkPDFModal').find('.modal-title').html('<i class="fas fa-bug"></i> Error');
					$('#bulkPDFModal').find('.modal-footer').html('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>');
					$('#bulkPDFModal').find('.modal-body').html('Ocurrio un error inesperado, contactar con soporte.');
					bulkPDFModal.show();
				}
			});
		}
	});
</script>

<?php include dirname(__FILE__) . '/views/footer.php'; ?> 
