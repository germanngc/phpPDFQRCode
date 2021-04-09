function submitForm() {
	grecaptcha.enterprise.ready(function() {
		grecaptcha.enterprise.execute('6Le-Go0aAAAAAL0ee1HWs5TCJ5w3ODInxrpJlFgw', {action: 'submit_covid_test_form'}).then(function(token) {
			document.getElementById('reCaptcha').value = token;
			document.getElementById('bookingFormRegister').submit();
			return true;
		});
	});

	return false;
}

document.addEventListener("DOMContentLoaded", function(event) {
	$('input[name=book_type]').on('change', function() {
		let $bookType = $(this).val(),
			$bookFamilyDefault = $('#book_family2'),
			$bookFamilyContainer = $('#book_family_container'),
			$bookFamilyOptions = $('#book_family_options');

		if ($bookType == 'group') {
			$bookFamilyContainer.find('label').removeClass('text-muted');
			$bookFamilyContainer.find('label span').addClass('form-required-star');
			$bookFamilyContainer.show();
		} else {
			$bookFamilyDefault.prop('checked', true);
			$bookFamilyContainer.find('label').addClass('text-muted');
			$bookFamilyContainer.find('label span').removeClass('form-required-star');
			$bookFamilyContainer.hide();
		}
	});

	$('input[name=test_type]').on('change', function() {
		let $testType = $(this).val(),
			$PCRContainer = $('#pcr_container');

		if ($testType == 'antigen') {
			$PCRContainer.hide();
			$PCRContainer.find('input[type=checkbox]:checked').prop('checked', false);
			$PCRContainer.find('input[type=radio]#pcr_interpretation1').prop('checked', true).change();
			$('input[type=radio]#test_result1').prop('checked', true).change();
			$('input[type=radio][name=test_result]').attr('readonly', false);
			$('input[name=test_method]').val('Inmuno Ensayo Cromatográfico / Cromotography immunoassay');
			$('#Guests').find('input[id$=test_type_1]').prop('checked', true);
		} else {
			$('input[type=radio]#test_result1').prop('checked', true).change();
			$('input[type=radio][name=test_result]').attr('readonly', true);
			$('input[name=test_method]').val('RT-PCR');
			$PCRContainer.show();
			$('#Guests').find('input[id$=test_type_2]').prop('checked', true);
		}
	});

	let todayDate = new Date();
	todayDate.setDate(todayDate.getDate() - 1);

	$('.datePicker').datepicker({
		dateFormat: 'mm/dd/yyyy',
		defaultDate: todayDate
	});
	
	// Merging Dates
	let test_date_taken = document.getElementById('test_date_taken');

	if (test_date_taken) {
		test_date_taken.addEventListener('change', function(event) {
			$('#test_date_result').val(this.value).datepicker('setDate', this.value)
		});
	}

	let counter = 0;

	$('input[name=book_type]').on('click', function() {
		if (this.value == 'group') {
			$('#addrow').trigger('click');
		} else {
			$('#Guests').find('.guest-item').remove();
		}
	});

	$('#addrow').on('click', function() {
		let $newRow = $('<div class="row g-2 guest-item">'),
			testValue = $('input[name=test_type]:checked').val(),
			emailValue = $('input[name=email]').val();

		$newRow.append(
`<div class="col-md mb-2">
	<div class="form-floating">
		<div class="form-check">
			<input type="radio" class="form-check-input"
				id="party_members_` + counter + `_test_type_1"
				name="party_members[` + counter + `][test_type]" value="antigen"
				` + (testValue == 'antigen' ? 'checked' : '') + `
				required>
			<label for="party_members_` + counter + `_test_type_1" class="form-check-label">Antigen <span class="form-required-star"></span></label>
		</div>
		<div class="form-check">
			<input type="radio" class="form-check-input"
				id="party_members_` + counter + `_test_type_2"
				name="party_members[` + counter + `][test_type]" value="pcr"
				` + (testValue == 'pcr' ? 'checked' : '') + `
				required>
			<label for="party_members_` + counter + `_test_type_2" class="form-check-label">RT-PCR <span class="form-required-star"></span></label>
		</div>
	</div>
</div>`
		);

		$newRow.append(
`<div class="col-md mb-2">
	<div class="form-floating">
		<input type="text" class="form-control form-control-sm"
			id="party_members_` + counter + `_name"
			name="party_members[` + counter + `][name]"
			placeholder="John"
			required>
		<label for="party_members_` + counter + `_name">First Name <span class="form-required-star"></span></label>
	</div>
</div>`
		);

		$newRow.append(
`<div class="col-md mb-2">
	<div class="form-floating">
		<input type="text" class="form-control form-control-sm"
			id="party_members_` + counter + `_lastname"
			name="party_members[` + counter + `][lastname]"
			placeholder="Doe"
			required>
		<label for="party_members_` + counter + `_lastname">Last Name <span class="form-required-star"></span></label>
	</div>
</div>`
		);

		$newRow.append(
`<div class="col-md mb-2">
	<div class="form-floating">
		<input type="text" class="form-control form-control-sm"
			id="party_members_` + counter + `_email"
			name="party_members[` + counter + `][email]"
			placeholder="john@doe.com"
			value="` + emailValue + `"
			required>
		<label for="party_members_` + counter + `_email">Email <span class="form-required-star"></span></label>
	</div>
</div>`
		);

		$newRow.append(
`<div class="col-md mb-2">
	<div class="form-floating">
		<input type="text" class="form-control form-control-sm datePicker"
			id="party_members_` + counter + `_birthdate"
			name="party_members[` + counter + `][birthdate]"
			placeholder="mm/dd/yyyy"
			required>
		<label for="party_members_` + counter + `_birthdate">Date of Birth <span class="form-required-star"></span></label>
	</div>
</div>`
		);

		$newRow.append(
`<div class="col-md mb-2">
	<div class="form-floating">
		<div class="form-check">
			<input type="radio" class="form-check-input" id="party_members_` + counter + `_sex_1" name="party_members[` + counter + `][sex]" value="female" required>
			<label for="party_members_` + counter + `_sex_1" class="form-check-label">Female <span class="form-required-star"></span></label>
		</div>
		<div class="form-check">
			<input type="radio" class="form-check-input" id="party_members_` + counter + `_sex_2" name="party_members[` + counter + `][sex]" value="male" required>
			<label for="party_members_` + counter + `_sex_2" class="form-check-label">Male <span class="form-required-star"></span></label>
		</div>
	</div>
</div>`
		);

		$newRow.append(
`<div class="col-md mb-2">
	<div class="form-floating">
		<input type="text" class="form-control form-control-sm"
			id="party_members_` + counter + `_passport"
			name="party_members[` + counter + `][passport]"
			minlength="6" maxlength="9"
			placeholder="L898902C"
			required>
		<label for="party_members_` + counter + `_lastname">Passport <span class="form-required-star"></span></label>
	</div>
</div>`
		);

		$newRow.append(
`<div class="col-md-1 mb-2">
	<div class="d-flex flex-row-reverse">
		<div class="p-2">
			<button type="button" class="ibtnDel btn btn-md btn-danger"><i class="fa fa-times"></i></button>
		</div>
	</div>
</div>`
		);

		$("#Guests").append($newRow);

		counter++;
	});

	$('#Guests').on('click', '.ibtnDel', function(event) {
		$(this).closest('.guest-item').remove();
		counter -= 1;
	});

	$(document).on('focus', '.datePicker', function() {
		$(this).datepicker();
	});
});
