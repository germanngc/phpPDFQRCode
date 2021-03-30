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
		} else {
			$('input[type=radio]#test_result1').prop('checked', true).change();
			$('input[type=radio][name=test_result]').attr('readonly', true);
			$('input[name=test_method]').val('RT-PCR');
			$PCRContainer.show();
		}
	});

	let todayDate = new Date();
	todayDate.setDate(todayDate.getDate() - 1);

	$(".datePicker").datepicker({
		dateFormat: 'mm/dd/yyyy',
		defaultDate: todayDate
	});
	
	// Merging Dates
	let test_date_taken = document.getElementById('test_date_taken');

	test_date_taken.addEventListener('change', function(event) {
		$("#test_date_result").val(this.value).datepicker('setDate', this.value)
	});
});