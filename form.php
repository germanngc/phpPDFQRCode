<?php
require_once dirname(__FILE__) . '/config/config.php';
require_once dirname(__FILE__) . '/config/forms.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$phpPDFQRForms::createForm($_POST);
}

$pageTitle = "Formulario de Registro // Registry Form";

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
		<h2>SARS-CoV-2 (COVID-19) Royal Islander Individual Form</h2>
		<p>Un formulario por individuo es requerido // One individual form per person is required</p>
	</div>

	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<form action="<?php echo $phpPDFQRConfig::$rootURL; ?>/form.php" id="bookingFormRegister" method="POST" onsubmit="return submitForm();">
			<div class="mb-3">
				<div><span class="form-required-star"></span><span>Requerido // Required</span></div>

				<h2>Información Personal // Personal Information </h2>
			</div>

			<div class="mb-3">
				<hr>

				<label for="" class="form-label">1. Tipo de prueba // Type of test <span class="form-required-star"></span></label>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="type_test" id="test_type1" value="antigen" checked required>
					<label class="form-check-label" for="test_type1">COVID-19 Antigen Test (Free of charge)</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="type_test" id="test_type2" value="pcr" required>
					<label class="form-check-label" for="test_type2">COVID-19 PCR Test (USD $116)</label>
				</div>
			</div>

			<div class="mb-3">
				<hr>

				<label for="name" class="form-label">2. Nombre(s) // Name(s) <span class="form-required-star"></span></label>
				<input type="text" class="form-control" id="name" name="name" placeholder="" required>
				<div id="nameHelp" class="form-text">Como estan en su identificación // As stated in your passport.</div>
			</div>

			<div class="mb-3">
				<hr>

				<label for="lastname" class="form-label">3. Apellidos // Last Names <span class="form-required-star"></span></label>
				<input type="text" class="form-control" id="lastname" name="lastname" placeholder="" required>
				<div id="lastnameHelp" class="form-text">Como estan en su identificación // As stated in your passport.</div>
			</div>

			<div class="mb-3">
				<hr>

				<label for="email" class="form-label">4. Correo Electrónico // Email <span class="form-required-star"></span></label>
				<input type="email" class="form-control" id="email" name="email" placeholder="" required>
			</div>

			<div class="mb-3">
				<hr>

				<label for="birthdate" class="form-label">5. Fecha de Nacimiento // Birthdate <span class="form-required-star"></span></label>
				<input type="date" class="form-control" id="birthdate" name="birthdate" placeholder="" required>
				<div id="birthdateHelp" class="form-text">Use el selector de su navegador // Use your brwoser selector.</div>
			</div>

			<div class="mb-3">
				<hr>

				<label for="email" class="form-label">6. Sexo // Sex <span class="form-required-star"></span></label>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="sex" id="sex1" value="male" checked required>
					<label class="form-check-label" for="sex1">Masculino // Male</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="sex" id="sex2" value="female" required>
					<label class="form-check-label" for="sex2">Femenino // Female</label>
				</div>
			</div>

			<div class="mb-3">
				<hr>

				<label for="passport" class="form-label">7. Numero de Identificación // Passport Number <span class="form-required-star"></span></label>
				<input type="text" class="form-control" id="passport" name="passport" placeholder="L898902C" minlength="6" maxlength="9" required>
			</div>

			<div class="mb-3">
				<hr>

				<label for="villa" class="form-label">8. Numero Villa // Villa Number <span class="form-required-star"></span></label>
				<input type="text" class="form-control" id="villa" name="villa" placeholder="" required>
			</div>

			<div class="mb-3">
				<hr>

				<label for="departuredate" class="form-label">9. Fecha de salida // Departure date <span class="form-required-star"></span></label>
				<input type="date" class="form-control" id="departuredate" name="departuredate" placeholder="" required>
				<div id="departuredateHelp" class="form-text">Use el selector de su navegador // Use your brwoser selector.</div>
			</div>

			<div class="mb-3" id="book_type_container">
				<hr>

				<label for="email" class="form-label">10. Usted esta reservando como un miembre de una Familia/Grupo o como Individuo? // Are you booking as a Family/Group member or as an Individual member? <span class="form-required-star"></span></label>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="book_type" id="book_type1" value="individual" checked required>
					<label class="form-check-label" for="book_type1">Individuo // Individual</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="book_type" id="book_type2" value="group" required>
					<label class="form-check-label" for="book_type2">Grupo/Familia // Group/Family</label>
				</div>
			</div>

			<div class="mb-3" id="book_family_container" style="display: none;">
				<hr>

				<label for="email" class="form-label">11. Are you the main member of Family/Group and/or booking the appointment on behalf of all of them? // Are you the main member of Family/Group and/or booking the appointment on behalf of all of them? <span class="form-required-star"></span></label>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="book_family" id="book_family1" value="yes" required>
					<label class="form-check-label" for="book_family1">Si - Reserver // Yes - Book</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="book_family" id="book_family2" value="no" checked required>
					<label class="form-check-label" for="book_family2">No - No reservar // No - Don't book</label>
				</div>
			</div>

			<input type="hidden" name="reCaptcha" id="reCaptcha" value="">
			<button type="submit" class="btn btn-primary mb-3">Registrar // Register</button>
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
