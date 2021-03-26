<?php
require_once dirname(__FILE__) . '/config/config.php';

$pageTitle = "Dashboard";

include dirname(__FILE__) . '/views/body.php';
?> 
<main class="container">
	<?php $phpPDFQRConfig::flashGet(); ?> 

	<div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
		<div class="lh-1">
			<h1 class="h6 mb-1 text-white lh-1">zogen | Laboratorio Salazar</h1>
			<small>Administrador de Pruebas SARS-CoV-2 (COVID 19)</small>
		</div>
	</div>

	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<h6 class="border-bottom pb-2 mb-0">Vista Previa Registros</h6>

		<?php
$sql = "SELECT * FROM covid_tests ORDER BY created_at DESC LIMIT 10;";
$results = mysqli_query($phpPDFQRConfig::$con, $sql);
		?><div class="d-flex text-muted pt-3">
			<div class="pb-3 mb-0 small lh-sm border-bottom w-100">
				<div class="d-flex justify-content-between">
				<table id="myTable" class="table table-striped table-bordered cell-border" style="width:100%">
					<thead>
						<tr>
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
						</tr>
					</thead>
					<tbody>
						<?php 
						while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
						?>
						<tr>
							<td><?php echo $row['first_name']; ?></td>
							<td><?php echo $row['last_name']; ?></td>
							<td><?php echo $row['email']; ?></td>
							<td><?php echo $row['birthdate']; ?></td>
							<td><?php echo $row['sex']; ?></td>
							<td><?php echo $row['passport']; ?></td>
							<td><?php echo $row['villa']; ?></td>
							<td><?php echo $row['reservation_number']; ?></td>
							<td><?php echo $row['departuredate']; ?></td>
							<td><?php echo $row['book_type']; ?></td>
							<td><?php echo $row['book_family']; ?></td>
							<td><?php echo $row['test_type']; ?></td>
							<td><?php echo $row['test_date_taken']; ?></td>
							<td><?php echo $row['test_date_result']; ?></td>
							<td><?php echo $row['test_reference']; ?></td>
							<td><?php echo $row['test_method']; ?></td>
							<td><?php echo $row['test_result']; ?></td>
							<td><?php echo $row['test_sample']; ?></td>
						</tr>
						<?php } ?>
					</tbody>
					<tfoot>
						<tr>
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
						</tr>
					</tfoot>
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
