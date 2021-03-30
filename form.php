<?php
require_once dirname(__FILE__) . '/config/config.php';
require_once dirname(__FILE__) . '/config/forms.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$phpPDFQRForms::createForm($_POST);
}

$pageTitle = "Registry Form";

include dirname(__FILE__) . '/views/body.php';
?> 
<main class="container">
	<?php $phpPDFQRConfig::flashGet(); ?> 

	<div class="my-3 p-3 bg-labsal text-labsal rounded shadow-sm">
		<h2>SARS-CoV-2 (COVID-19) Royal Islander Individual Form</h2>
		<p>One individual form per person is required</p>
	</div>

	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<form action="<?php echo $phpPDFQRConfig::$rootURL; ?>/form.php" id="bookingFormRegister" method="POST" onsubmit="return submitForm();">
			<div class="row">
				<div class="col-md-12 mb-3 border-bottom py-4">
					<h2>Personal Information</h2>
					<div><span class="form-required-star"></span><span>Required</span></div>
				</div>

				<div class="col-md-12 mb-3 border-bottom py-4">
					<label for="" class="form-label">1. Test Type <span class="form-required-star"></span></label>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="test_type" id="test_type1" value="antigen" checked required>
						<label class="form-check-label" for="test_type1">COVID-19 Antigen Test (Free of charge)</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="test_type" id="test_type2" value="pcr" required>
						<label class="form-check-label" for="test_type2">COVID-19 RT-PCR Test (USD $100)**</label>
					</div>
					<div id="lastnameHelp" class="form-text">**Reverse Transcription Polymerase Chain Reaction.</div>
				</div>

				<div class="col-md-6 mb-3 border-bottom py-4">
					<label for="name" class="form-label">2. First Name <span class="form-required-star"></span></label>
					<input type="text" class="form-control" id="name" name="name" required>
					<div id="nameHelp" class="form-text">As displayed in your passport.</div>
				</div>

				<div class="col-md-6 mb-3 border-bottom py-4">
					<label for="lastname" class="form-label">3. Last Name <span class="form-required-star"></span></label>
					<input type="text" class="form-control" id="lastname" name="lastname" required>
					<div id="lastnameHelp" class="form-text">As displayed in your passport.</div>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="email" class="form-label">4. Email <span class="form-required-star"></span></label>
					<input type="email" class="form-control" id="email" name="email" required>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="birthdate" class="form-label">5. Date of Birth <span class="form-required-star"></span></label>
					<input type="text" class="form-control datePicker" id="birthdate" name="birthdate" placeholder="mm/dd/yyyy" required>
					<div id="birthdateHelp" class="form-text">Use your browser selector.</div>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="email" class="form-label">6. Sex <span class="form-required-star"></span></label>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="sex" id="sex2" value="female" required>
						<label class="form-check-label" for="sex2">Female</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="sex" id="sex1" value="male" required>
						<label class="form-check-label" for="sex1">Male</label>
					</div>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="passport" class="form-label">7. Passport Number <span class="form-required-star"></span></label>
					<input type="text" class="form-control" id="passport" name="passport" placeholder="L898902C" minlength="6" maxlength="9" required>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="reservation_number" class="form-label">8. Reservation Number <span class="form-required-star"></span></label>
					<input type="text" class="form-control" id="reservation_number" name="reservation_number" required>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="villa" class="form-label">9. Villa Number </label>
					<input type="text" class="form-control" id="villa" name="villa">
				</div>

				<div class="col-md-12 mb-3 border-bottom py-4" id="book_type_container">
					<label for="book_type" class="form-label">10. Please select the appropriate option: are you booking for yourself, or on behalf of a group or family? <span class="form-required-star"></span></label>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="book_type" id="book_type1" value="individual" checked required>
						<label class="form-check-label" for="book_type1">Myself</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="book_type" id="book_type2" value="group" required>
						<label class="form-check-label" for="book_type2">Group or family</label>
					</div>
				</div>

				<div class="col-md-12 mb-3 border-bottom py-4" id="book_family_container">
					<label for="book_family" class="form-label text-muted">11. Are you the main member of Family/Group and/or booking the appointment on behalf of all of them? <span class=""></span></label>
					<div id="book_family_options" style="display: none;">
						<div class="form-check">
							<input class="form-check-input" type="radio" name="book_family" id="book_family1" value="yes" required>
							<label class="form-check-label" for="book_family1">Yes - Book</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="book_family" id="book_family2" value="no" checked required>
							<label class="form-check-label" for="book_family2">No - Don't book</label>
						</div>
					</div>
				</div>

				<div class="col-md-12 mb-3">
					<div class="d-grid gap-2">
						<button type="submit" class="btn btn-labsal btn-lg btn-block mb-3">Submit</button>
					</div>
				</div>

				<input type="hidden" name="reCaptcha" id="reCaptcha" value="">
			</div>
		</form>
	</div>
</main>

<script src="https://www.google.com/recaptcha/enterprise.js?render=6Le-Go0aAAAAAL0ee1HWs5TCJ5w3ODInxrpJlFgw"></script>
<script src="<?php echo $phpPDFQRConfig::$rootURL; ?>/assets/js/form.js?v=210329"></script>
<?php include dirname(__FILE__) . '/views/footer.php'; ?> 
