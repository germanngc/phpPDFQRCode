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
			$bookFamilyOptions.show();
		} else {
			$bookFamilyDefault.prop('checked', true);
			$bookFamilyContainer.find('label').addClass('text-muted');
			$bookFamilyContainer.find('label span').removeClass('form-required-star');
			$bookFamilyOptions.hide();
		}
	});
	
	// Merging Dates
	let test_date_taken = document.getElementById('test_date_taken'),
		test_date_result = document.getElementById('test_date_result');

	test_date_taken.addEventListener('change', function(event) {
		test_date_result.value = this.value;
	});
});