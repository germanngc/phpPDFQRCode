<?php
require_once dirname(__FILE__) . '/config/config.php';
require_once dirname(__FILE__) . '/config/forms.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$phpPDFQRForms::updateForm($_POST);
}

$pageTitle = "Edición de Registro";

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
						<input class="form-check-input" type="radio" name="test_type" id="test_type1" value="antigen" <?php echo $row['test_type'] == 'antigen' ? 'checked' : '' ?>  required>
						<label class="form-check-label" for="test_type1">COVID-19 Antigen Test (Free of charge)</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="test_type" id="test_type2" value="pcr" <?php echo $row['test_type'] == 'pcr' ? 'checked' : '' ?> required>
						<label class="form-check-label" for="test_type2">COVID-19 RT-PCR Test (USD $100)**</label>
					</div>
					<div id="lastnameHelp" class="form-text">**Reverse Transcription Polymerase Chain Reaction.</div>
				</div>

				<div class="col-md-6 mb-3 border-bottom py-4">
					<label for="name" class="form-label">2. First Name <span class="form-required-star"></span></label>
					<input type="text" class="form-control" id="name" name="name" value="<?php echo $row['first_name']; ?>" required>
					<div id="nameHelp" class="form-text">As displayed in your passport.</div>
				</div>

				<div class="col-md-6 mb-3 border-bottom py-4">
					<label for="lastname" class="form-label">3. Last Name <span class="form-required-star"></span></label>
					<input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $row['last_name']; ?>" required>
					<div id="lastnameHelp" class="form-text">As displayed in your passport.</div>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="email" class="form-label">4. Email <span class="form-required-star"></span></label>
					<input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="birthdate" class="form-label">5. Date of Birth <span class="form-required-star"></span></label>
					<input type="text" class="form-control datePicker" id="birthdate" name="birthdate" value="<?php echo date("m/d/Y", strtotime($row['birthdate'])); ?>" placeholder="mm/dd/yyyy" required>
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
					<input type="text" class="form-control" id="reservation_number" name="reservation_number" value="<?php echo $row['reservation_number']; ?>" required>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="villa" class="form-label">9. Villa Number </label>
					<input type="text" class="form-control" id="villa" name="villa" value="<?php echo $row['villa']; ?>">
				</div>

				<div class="col-md-12 mb-3 border-bottom py-4" id="book_type_container">
					<label for="email" class="form-label">10. Please select the appropriate option: are you booking for yourself, or on behalf of a group or family? <span class="form-required-star"></span></label>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="book_type" id="book_type1" value="individual" <?php if($row['book_type']=='individual'){ echo'checked';} ?> required>
						<label class="form-check-label" for="book_type1">Myself</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="book_type" id="book_type2" value="group" <?php if($row['book_type']=='group'){ echo'checked';} ?> required>
						<label class="form-check-label" for="book_type2">Group or family</label>
					</div>
				</div>

				<div class="col-md-12 mb-3 border-bottom py-4" id="book_family_container">
					<label for="email" class="form-label<?php echo $row['book_type'] == 'individual' ? ' text-muted': ''; ?>">11. Are you the main member of Family/Group and/or booking the appointment on behalf of all of them? <span class="<?php echo $row['book_type'] == 'individual' ? '': 'form-required-star'; ?>"></span></label>
					<div id="book_family_options" style="display: <?php echo $row['book_type'] == 'individual' ? 'none': 'block'; ?>">
						<div class="form-check">
							<input class="form-check-input" type="radio" name="book_family" id="book_family1" value="yes" <?php if($row['book_family']=='yes'){ echo'checked';} ?> required>
							<label class="form-check-label" for="book_family1">Yes - Book (This form should be filled by all your family / group members individually)</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="book_family" id="book_family2" value="no" <?php if($row['book_family']=='no'){ echo'checked';} ?> required>
							<label class="form-check-label" for="book_family2">No - Don't book</label>
						</div>
					</div>
				</div>

				<div class="col-md-12 mb-3 border-bottom py-4">
					<label for="symptoms" class="form-label">12. Symptoms</label>
					<div id="symptomsHelp" class="form-text">Please check if any.</div>
					<?php
$symptoms_arr = explode(';', $row['symptoms']);
					?> 
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="symptoms[]" id="symptoms1" value="Tiredness" <?php echo in_array('Tiredness', $symptoms_arr) ? 'checked' : ''; ?>>
						<label class="form-check-label" for="symptoms1">Tiredness</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="symptoms[]" id="symptoms2" value="Aches and pains" <?php echo in_array('Aches and pains', $symptoms_arr) ? 'checked' : ''; ?>>
						<label class="form-check-label" for="symptoms2">Aches and pains</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="symptoms[]" id="symptoms3" value="Headache" <?php echo in_array('Headache', $symptoms_arr) ? 'checked' : ''; ?>>
						<label class="form-check-label" for="symptoms2">Headache</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="symptoms[]" id="symptoms4" value="Feber" <?php echo in_array('Feber', $symptoms_arr) ? 'checked' : ''; ?>>
						<label class="form-check-label" for="symptoms4">Feber</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="symptoms[]" id="symptoms5" value="Conjunctivitis" <?php echo in_array('Conjunctivitis', $symptoms_arr) ? 'checked' : ''; ?>>
						<label class="form-check-label" for="symptoms5">Conjunctivitis</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="symptoms[]" id="symptoms6" value="Sore throat" <?php echo in_array('Sore throat', $symptoms_arr) ? 'checked' : ''; ?>>
						<label class="form-check-label" for="symptoms6">Sore throat</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="symptoms[]" id="symptoms7" value="Dry cough" <?php echo in_array('Dry cough', $symptoms_arr) ? 'checked' : ''; ?>>
						<label class="form-check-label" for="symptoms7">Dry cough</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="symptoms[]" id="symptoms8" value="Runny Nose" <?php echo in_array('Runny Nose', $symptoms_arr) ? 'checked' : ''; ?>>
						<label class="form-check-label" for="symptoms8">Runny Nose</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="symptoms[]" id="symptoms9" value="Difficulty breathing or shortness of breath" <?php echo in_array('Difficulty breathing or shortness of breath', $symptoms_arr) ? 'checked' : ''; ?>>
						<label class="form-check-label" for="symptoms9">Difficulty breathing or shortness of breath</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="symptoms[]" id="symptoms10" value="Chest pain or pressure" <?php echo in_array('Chest pain or pressure', $symptoms_arr) ? 'checked' : ''; ?>>
						<label class="form-check-label" for="symptoms10">Chest pain or pressure</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="symptoms[]" id="symptoms11" value="Loss of taste or smell" <?php echo in_array('Loss of taste or smell', $symptoms_arr) ? 'checked' : ''; ?>>
						<label class="form-check-label" for="symptoms11">Loss of taste or smell</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="symptoms[]" id="symptoms12" value="A rash on skin, or discolouration of fingers or toes" <?php echo in_array('A rash on skin, or discolouration of fingers or toes', $symptoms_arr) ? 'checked' : ''; ?>>
						<label class="form-check-label" for="symptoms12">A rash on skin, or discolouration of fingers or toes</label>
					</div>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="patient_day_number" class="form-label">13. Patient Day Number</label>
					<input type="text" class="form-control" id="patient_day_number" name="patient_day_number" value="<?php echo $row['patient_day_number']; ?>">
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="test_date_taken" class="form-label">14. Date of Test Taken <span class="form-required-star"></span></label>
					<input type="text" class="form-control datePicker" id="test_date_taken" name="test_date_taken" value="<?php echo date("m/d/Y", strtotime($row['test_date_taken'] ? $row['test_date_taken'] : 'now')); ?>" placeholder="mm/dd/yyyy" required>
					<div id="test_date_takenHelp" class="form-text">Use your browser selector.</div>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="test_date_result" class="form-label">15. Date of Test Results <span class="form-required-star"></span></label>
					<input type="text" class="form-control datePicker" id="test_date_result" name="test_date_result" value="<?php echo date("m/d/Y", strtotime($row['test_date_result'] ? $row['test_date_result'] : 'now')); ?>" placeholder="mm/dd/yyyy" required>
					<div id="test_date_takenHelp" class="form-text">Use your browser selector.</div>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="test_result" class="form-label">16. Result of the Test <span class="form-required-star"></span></label>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="test_result" id="test_result1" value="negative"<?php echo $row['test_result'] != 'positive' ? ' checked' : ''; ?> required>
						<label class="form-check-label" for="test_result1">Negative (-)</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="test_result" id="test_result2" value="positive"<?php echo $row['test_result'] == 'positive' ? ' checked' : ''; ?> required>
						<label class="form-check-label" for="test_result2">Positive (+)</label>
					</div>
				</div>

				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="test_sample" class="form-label">17. Sample for the Test <span class="form-required-star"></span></label>
					<input type="text" class="form-control" id="test_sample" name="test_sample" value="<?php echo $row['test_sample'] ? $row['test_sample'] : 'Nasofaringea / Nasopharyngeal'; ?>" required>
				</div>
			
				<div class="col-md-4 mb-3 border-bottom py-4">
					<label for="test_method" class="form-label">18. Method of the Test <span class="form-required-star"></span></label>
					<input type="text" class="form-control" id="test_method" name="test_method" value="<?php echo $row['test_method'] ? $row['test_method'] : 'Inmuno Ensayo Cromatográfico / Cromotography immunoassay'; ?>" required>
				</div>

				<div class="col-md-12">
					<div class="row" id="pcr_container" style="display:<?php echo $row['test_type'] == 'pcr' ? 'flex' : 'none' ?>">
						<div class="col-md-6 mb-3 border-bottom py-4">
							<label for="pcr_observations" class="form-label">19. RT-PCR Observations </label>
							<div id="test_date_takenHelp" class="form-text">Mark if detected.</div>
							<?php
$pcr_observations_arr = explode(';', $row['pcr_observations']);
$pcr_observations_sample_arr = explode(';', $row['pcr_observations_sample']);
							?> 
							<div class="row">
								<div class="col-6">
									<label class="form-check-label text-muted">Reference</label>
									<hr>

									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="pcr_observations_sample[]" id="pcr_observations_sample_gen_e" value="gen_e" readonly <?php echo in_array('gen_e', $pcr_observations_sample_arr) ? 'checked' : ''; ?>>
										<label class="form-check-label text-muted" for="pcr_observations_sample_gen_e">Gen E</label>
									</div>

									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="pcr_observations_sample[]" id="pcr_observations_sample_gen_n" value="gen_n" readonly <?php echo in_array('gen_n', $pcr_observations_sample_arr) ? 'checked' : ''; ?>>
										<label class="form-check-label text-muted" for="pcr_observations_sample_gen_n">Gen N</label>
									</div>

									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="pcr_observations_sample[]" id="pcr_observations_sample_rnaasep" value="rnaasep" readonly <?php echo in_array('rnaasep', $pcr_observations_sample_arr) ? 'checked' : ''; ?>>
										<label class="form-check-label text-muted" for="pcr_observations_sample_rnaasep">RNAaseP</label>
									</div>
								</div>

								<div class="col-6">
									<label class="form-check-label">Result</label>
									<hr>

									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="pcr_observations[]" id="pcr_observations_gen_e" value="gen_e" <?php echo in_array('gen_e', $pcr_observations_arr) ? 'checked' : ''; ?>>
										<label class="form-check-label" for="pcr_observations_gen_e">Gen E</label>
									</div>

									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="pcr_observations[]" id="pcr_observations_gen_n" value="gen_n" <?php echo in_array('gen_n', $pcr_observations_arr) ? 'checked' : ''; ?>>
										<label class="form-check-label" for="pcr_observations_gen_n">Gen N</label>
									</div>

									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="pcr_observations[]" id="pcr_observations_rnaasep" value="rnaasep" <?php echo in_array('rnaasep', $pcr_observations_arr) ? 'checked' : ''; ?>>
										<label class="form-check-label" for="pcr_observations_rnaasep">RNAaseP</label>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-6 mb-3 border-bottom py-4">
							<label for="pcr_interpretation" class="form-label">20. RT-PCR Interpretation <span class="form-required-star"></span></label>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="pcr_interpretation" id="pcr_interpretation1" value="negative"<?php echo $row['pcr_interpretation'] != 'positive' ? ' checked' : ''; ?> required>
								<label class="form-check-label" for="pcr_interpretation1">Negative (-)</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="pcr_interpretation" id="pcr_interpretation2" value="positive"<?php echo $row['pcr_interpretation'] == 'positive' ? ' checked' : ''; ?> required>
								<label class="form-check-label" for="pcr_interpretation2">Positive (+)</label>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-12 mb-3">
					<div class="d-grid gap-2">
						<button type="submit" class="btn btn-labsal btn-lg btn-block mb-3">Submit</button>
					</div>
				</div>

				<input type="hidden" name="reCaptcha" id="reCaptcha" value="">
				<input type="hidden" name="test_reference" value="negative">
		</form>
	</div>
</main>

<script src="https://www.google.com/recaptcha/enterprise.js?render=6Le-Go0aAAAAAL0ee1HWs5TCJ5w3ODInxrpJlFgw"></script>
<script src="<?php echo $phpPDFQRConfig::$rootURL; ?>/assets/js/form.js?v=210330"></script>
<?php include dirname(__FILE__) . '/views/footer.php'; ?> 
