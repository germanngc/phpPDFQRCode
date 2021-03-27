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

	<div class="d-flex align-items-center p-3 my-3 bg-labsal text-labsal rounded shadow-sm">
		<div class="lh-1">
			<h1 class="h2 mb-1 text-white lh-3">zogen | Laboratorio Salazar</h1>
			<small>Administrador de Pruebas SARS-CoV-2 (COVID 19)</small>
		</div>
	</div>

	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<h6 class="border-bottom pb-2 mb-0">Vista Previa Registros</h6>

		<?php
$sql = "SELECT * FROM `covid_tests` ORDER BY `id` DESC;";
$results = mysqli_query($phpPDFQRConfig::$con, $sql);
		?><div class="d-flex text-muted pt-3">
			<div class="pb-3 mb-0 small lh-sm border-bottom w-100">
				<div class="d-flex justify-content-between">
				<table id="myTable" class="dataTable stripe compact order-column" data-order='[[ 1, "desc" ]]' style="font-size: .7rem; width: 100%">
					<thead>
						<tr>
							<th></th>
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
					<tbody>
						<?php 
while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
						?><tr>
							<td><input type="checkbox" name="id[]" value="<?php echo $row["id"]; ?>"></td>
							<td><?php echo 'RIH' . str_pad($row['id'], 7, "0", STR_PAD_LEFT); ?></td>
							<td><?php echo $row['first_name']; ?></td>
							<td><?php echo $row['last_name']; ?></td>
							<td><?php echo $row['email']; ?></td>
							<td><?php echo $row['birthdate']; ?></td>
							<td><?php echo $row['sex'] == 'male' ? 'Male' : 'Female'; ?></td>
							<td><?php echo $row['passport']; ?></td>
							<td><?php echo $row['villa']; ?></td>
							<td><?php echo $row['reservation_number']; ?></td>
							<td><?php echo $row['departuredate']; ?></td>
							<td><?php echo $row['book_type'] == 'individual' ? 'Myself' : 'Group or family'; ?></td>
							<td><?php echo $row['book_family'] == 'yes' ? 'Yes' : 'No'; ?></td>
							<td><?php echo $row['test_type'] == 'antigen' ? 'COVID-19 Antigen Test' : 'COVID-19 RT-PCR Test'; ?></td>
							<td><?php echo $row['test_date_taken']; ?></td>
							<td><?php echo $row['test_date_result']; ?></td>
							<td><?php echo $row['test_reference']; ?></td>
							<td><?php echo $row['test_method']; ?></td>
							<td><?php echo $row['test_result']; ?></td>
							<td><?php echo $row['test_sample']; ?></td>
							<td><?php echo $row['created_at']; ?></td>
							<td><?php echo $row['updated_at']; ?></td>
						</tr>
						<?php
}
						?> 
					</tbody>
				</table>
				</div>
			</div>
		</div>
		<?php
// Free result set
mysqli_free_result($results);
		?> 
	</div>
</main>

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
			autoWidth: 'false',
			scrollX: 'true',
			dom: 'Bfrtip',
			columnDefs: [{
				orderable: false,
				className: 'select-checkbox',
				targets: 0
			}],
			buttons: [
				$.extend(true, {}, buttonCommon, {
					extend: 'excelHtml5',
					text: 'Export to Excel',
					exportOptions: {
						columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21]
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
