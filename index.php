<?php
require_once dirname(__FILE__) . '/config/config.php';

$pageTitle = "Dashboard";

include dirname(__FILE__) . '/views/body.php';
?> 
<style>
	.dataTables_wrapper .dt-buttons {
		margin-bottom: .75rem;
	}
</style>

<main class="container-fluid">
	<?php $phpPDFQRConfig::flashGet(); ?> 

	<div class="d-flex align-items-center p-3 my-3 mb-0 bg-labsal text-labsal rounded shadow-sm" style="position:relative">
		<div class="lh-1">
			<h1 class="h2 mb-1 lh-3">zogen | Laboratorio Salazar</h1>
			<small>Administrador de Pruebas SARS-CoV-2 (COVID 19)</small>
		</div>
	</div>

	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<table id="myTable" class="dataTable stripe nowrap order-column" data-order='[[ 3, "desc" ]]' style="font-size: 1rem; width: 100%">
			<thead>
				<tr>
					<th></th>
					<th><i class="far fa-file-pdf"></i></th>
					<th><i class="fas fa-envelope-open-text"></i></th>
					<th>File</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Birth date</th>
					<th>Sex</th>
					<th>Passport</th>
					<th>Villa</th>
					<th>Reservation number</th>
					<th>Departure date</th>
					<th>Book type</th>
					<th>Book family</th>
					<th>Test type</th>
					<th>Test date taken</th>
					<th>Test date result</th>
					<th>Test reference</th>
					<th>Test method</th>
					<th>Test result</th>
					<th>Test sample</th>
					<th>Created at</th>
					<th>Updated at</th>
				</tr>
			</thead>
		</table>
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

<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		let buttonCommon = {
			exportOptions: {
				format: {
					body: function (data, row, column, node) {
						return column === 5 ?
							data.replace( /[$,]/g, '' ) :
							data;
					}
				}
			}
		};

		$('.dataTable').DataTable({
			pageLength: 100,
			autoWidth: 'false',
			processing: true,
			serverSide: true,
			ajax: {
				url: "<?php echo $phpPDFQRConfig::$rootURL; ?>/apis/api.php?action=getForms",
				type: "post",
				error: function() {}
			},
			scrollX: 'true',
			dom: 'Bfrtip',
			responsive: true,
			columnDefs: [{
				orderable: false,
				className: 'select-checkbox',
				targets: [0, 1, 2]
			}],
			buttons: [
				$.extend(true, {}, buttonCommon, {
					extend: 'excelHtml5',
					text: 'Export to Excel',
					exportOptions: {
						columns: [3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23]
					}
				}),
				{
					text: 'Generate PDF Batch from Selected',
					className: 'buttons-bulk-pdf',
					action: function ( e, dt, node, config ) {
						let selected = $('.dataTable td.select-checkbox input[type=checkbox]:checked');
						console.log('xgngcx', selected);
					}
				}
			]
		});
	});
</script>

<?php include dirname(__FILE__) . '/views/footer.php'; ?> 
