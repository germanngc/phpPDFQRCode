<?php
require_once dirname(__FILE__) . '/config/config.php';
require_once dirname(__FILE__) . '/config/forms.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$phpPDFQRForms::updateForm($_POST);
}

$pageTitle = "Formulario de Registro // Registry Form";

include dirname(__FILE__) . '/views/body.php';

$id = $_GET['id'];
$row = $phpPDFQRForms::showForm($id);
?> 
<main class="container">
	<?php $phpPDFQRConfig::flashGet(); ?> 

	<div class="my-3 p-3 bg-labsal text-labsal rounded shadow-sm">
		<h2>SARS-CoV-2 (COVID-19) Royal Islander Individual Form</h2>
		<p>One individual form per person is required</p>
	</div>

	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<form action="<?php echo $phpPDFQRConfig::$rootURL; ?>/form-edit.php?id=<?php echo $id; ?>" id="bookingFormRegister" method="POST" onsubmit="return submitForm();">
			<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['id']; ?>" required>

			<div class="row">
				<div class="col-md-12 mb-3 border-bottom py-4">
					<h2>Personal Information</h2>
					<div><span class="form-required-star"></span><span>Required</span></div>
				</div>

				<div class="col-md-12 mb-3 border-bottom py-4">
					<label for="" class="form-label">1. Test Type <span class="form-required-star"></span></label>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="test_type" id="test_type1" value="antigen" <?php if($row['test_type']=='antigen'){ echo'checked';} ?>  required>
						<label class="form-check-label" for="test_type1">COVID-19 Antigen Test (Free of charge)</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="test_type" id="test_type2" value="pcr" <?php if($row['test_type']=='pcr'){ echo'checked';} ?> required>
						<label class="form-check-label" for="test_type2">COVID-19 RT-PCR Test (USD $116)**</label>
					</div>
					<div id="lastnameHelp" class="form-text">**Reverse Transcription Polymerase Chain Reaction.</div>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="name" class="form-label">2. First Name <span class="form-required-star"></span></label>
					<input type="text" class="form-control" id="name" name="name" value="<?php echo $row['first_name']; ?>" placeholder="" required>
					<div id="nameHelp" class="form-text">As displayed in your passport.</div>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="lastname" class="form-label">3. Last Name <span class="form-required-star"></span></label>
					<input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $row['last_name']; ?>" placeholder="" required>
					<div id="lastnameHelp" class="form-text">As displayed in your passport.</div>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="email" class="form-label">4. Email <span class="form-required-star"></span></label>
					<input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" placeholder="" required>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="birthdate" class="form-label">5. Date of Birth <span class="form-required-star"></span></label>
					<input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo $row['birthdate']; ?>" placeholder="" required>
					<div id="birthdateHelp" class="form-text">Use your browser selector.</div>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="email" class="form-label">6. Sex <span class="form-required-star"></span></label>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="sex" id="sex1" value="male" <?php if($row['sex']=='male'){ echo'checked';} ?> required>
						<label class="form-check-label" for="sex1">Male</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="sex" id="sex2" value="female" <?php if($row['sex']=='female'){ echo'checked';} ?> required>
						<label class="form-check-label" for="sex2">Female</label>
					</div>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="passport" class="form-label">7. Passport Number <span class="form-required-star"></span></label>
					<input type="text" class="form-control" id="passport" name="passport" value="<?php echo $row['passport']; ?>" placeholder="L898902C" minlength="6" maxlength="9" required>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="reservation_number" class="form-label">8. Reservation Number <span class="form-required-star"></span></label>
					<input type="text" class="form-control" id="reservation_number" name="reservation_number" value="<?php echo $row['reservation_number']; ?>" placeholder="" required>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="villa" class="form-label">9. Villa Number <span class="form-required-star"></span></label>
					<input type="text" class="form-control" id="villa" name="villa" value="<?php echo $row['villa']; ?>" placeholder="" required>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="departuredate" class="form-label">10. Date of Departure <span class="form-required-star"></span></label>
					<input type="date" class="form-control" id="departuredate" name="departuredate" value="<?php echo $row['departuredate']; ?>" placeholder="" required>
					<div id="departuredateHelp" class="form-text">Use your browser selector.</div>
				</div>

				<div class="col-md-12 mb-3 border-bottom py-4" id="book_type_container">
					<label for="email" class="form-label">11. Please select the appropriate option: are you booking for yourself, or on behalf of a group or family? <span class="form-required-star"></span></label>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="book_type" id="book_type1" value="individual" <?php if($row['book_type']=='individual'){ echo'checked';} ?> required>
						<label class="form-check-label" for="book_type1">Myself</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="book_type" id="book_type2" value="group" <?php if($row['book_type']=='group'){ echo'checked';} ?> required>
						<label class="form-check-label" for="book_type2">Group or family</label>
					</div>
				</div>

				<div class="col-md-12 mb-3 border-bottom py-4" id="book_family_container" <?php if($row['book_type']=='individual'){ echo'style="display: none;" ';} ?>>
					<label for="email" class="form-label">12. Are you the main member of Family/Group and/or booking the appointment on behalf of all of them? <span class="form-required-star"></span></label>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="book_family" id="book_family1" value="yes" <?php if($row['book_family']=='yes'){ echo'checked';} ?> required>
						<label class="form-check-label" for="book_family1">Yes - Book</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="book_family" id="book_family2" value="no" <?php if($row['book_family']=='no'){ echo'checked';} ?> required>
						<label class="form-check-label" for="book_family2">No - Don't book</label>
					</div>
				</div>

				<!--<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="expedient" class="form-label">13. File Record <span class="form-required-star"></span></label>
					<input type="text" class="form-control" id="expedient" name="expedient" value="RIF<?php echo str_pad($row['id'], 7, "0", STR_PAD_LEFT); ?>" placeholder="" readonly>
				</div>-->
			
				<div class="col-md-6 mb-3 border-bottom py-4">
					<label for="test_date_taken" class="form-label">13. Date of Test Taken <span class="form-required-star"></span></label>
					<input type="date" class="form-control" id="test_date_taken" name="test_date_taken" value="<?php echo $row['test_date_taken']; ?>" placeholder="" required>
					<div id="test_date_takenHelp" class="form-text">Use your browser selector.</div>
				</div>

				<div class="col-md-6 mb-3 border-bottom py-4">
					<label for="test_date_result" class="form-label">14. Date of Test Results <span class="form-required-star"></span></label>
					<input type="date" class="form-control" id="test_date_result" name="test_date_result" value="<?php echo $row['test_date_result']; ?>" placeholder="" required>
					<div id="test_date_takenHelp" class="form-text">Use your browser selector.</div>
				</div>

				<div class="col-md-6 mb-3 border-bottom py-4">
					<label for="test_result" class="form-label">15. Result of the Test <span class="form-required-star"></span></label>
					<input type="text" class="form-control" id="test_result" name="test_result" value="<?php echo $row['test_result']; ?>" placeholder="" required>
				</div>

				<div class="col-md-6 mb-3 border-bottom py-4">
					<label for="test_reference" class="form-label">16. Referencia de Test // Test Reference <span class="form-required-star"></span></label>
					<input type="text" class="form-control" id="test_reference" name="test_reference" value="<?php echo $row['test_reference']; ?>" placeholder="" required>
				</div>

				<div class="col-md-6 mb-3 border-bottom py-4">
					<label for="test_sample" class="form-label">17. Sample for the Test <span class="form-required-star"></span></label>
					<input type="text" class="form-control" id="test_sample" name="test_sample" value="<?php echo $row['test_sample']; ?>" placeholder="" required>
				</div>
			
				<div class="col-md-6 mb-3 border-bottom py-4">
					<label for="test_method" class="form-label">18. Method of the Test <span class="form-required-star"></span></label>
					<input type="text" class="form-control" id="test_method" name="test_method" value="<?php echo $row['test_method']; ?>" placeholder="" required>
				</div>

				<div class="col-md-12 mb-3" id="book_type_container">
					<div class="d-grid gap-2">
						<button type="submit" class="btn btn-labsal btn-lg btn-block mb-3">Submit</button>
					</div>
				</div>

				<input type="hidden" name="reCaptcha" id="reCaptcha" value="">
		</form>
	</div>
</main>

<script src="https://www.google.com/recaptcha/enterprise.js?render=6Le-Go0aAAAAAL0ee1HWs5TCJ5w3ODInxrpJlFgw"></script>
<script>
	function submitForm() {
		grecaptcha.enterprise.ready(function() {
			grecaptcha.enterprise.execute('6Le-Go0aAAAAAL0ee1HWs5TCJ5w3ODInxrpJlFgw', {action: 'submit_covid_test_form'}).then(function(token) {
				console.log('Here there', token);

				document.getElementById('reCaptcha').value = token;
				document.getElementById('bookingFormRegister').submit();
				return true;
			});
		});

		return false;
	}

	document.addEventListener("DOMContentLoaded", function(event) {
		const book_family_container = document.getElementById('book_family_container');
		const book_type_action = document.getElementsByName('book_type');

		book_type_action.forEach(function(elem) {
			elem.addEventListener("change", function(event) {
				if (this.value == 'group') {
					book_family_container.style.display = 'block';
				} else {
					document.getElementById('book_family2').checked = true;
					book_family_container.style.display = 'none';
				}
			});
		});
	});
</script>
<?php include dirname(__FILE__) . '/views/footer.php'; ?> 
