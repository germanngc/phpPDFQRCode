<?php
class phpPDFQRForms extends phpPDFQRConfig
{
	// Do not remove or phpPDFQRConfig construct will be executed twice
	public function __construct() {}

	public static function createForm($data)
	{
		$name = mysqli_real_escape_string(self::$con, $data["name"]);
		$lastname = mysqli_real_escape_string(self::$con, $data["lastname"]);
		$email = mysqli_real_escape_string(self::$con, $data["email"]);
		$birthdate = mysqli_real_escape_string(self::$con, $data["birthdate"]);
		$sex = mysqli_real_escape_string(self::$con, $data["sex"]);
		$passport = mysqli_real_escape_string(self::$con, $data["passport"]);
		$villa = mysqli_real_escape_string(self::$con, $data["villa"]);
		$departuredate = mysqli_real_escape_string(self::$con, $data["departuredate"]);
		$book_type = mysqli_real_escape_string(self::$con, $data["book_type"]);
		$book_family = mysqli_real_escape_string(self::$con, $data["book_family"]);
		$test_type = mysqli_real_escape_string(self::$con, $data["test_type"]);

		$sql = "INSERT INTO covid_tests " .
			"(first_name, last_name, email, birthdate, sex, passport, villa, departuredate, book_type, book_family, test_type, created_at) " .
			"VALUES " .
			"('{$name}', '{$lastname}', '{$email}', '{$birthdate}', '{$sex}', '{$passport}', '{$villa}', '{$departuredate}', '{$book_type}', '{$book_family}', '{$test_type}', '" . date('Y-m-d H:i:s'). "');";

		if (!mysqli_query(self::$con, $sql)) {
			self::log('error', 'Unable to insert a record. ' . mysqli_error(self::$con));
			self::flashSet("Error", "No se pudo crear su registro, contacte con soporte. // Could not create the record, please contact support.", "danger");
			return;
		}

		self::flashSet("Success", "Se ha creado con éxito nos pondremos en contacto con usted. // Form successfully submited, we will be in touch with you shortly.", "success");
		header("location: " . self::$rootURL . "/form.php");
		die();
	}

	public static function updateForm($data)
	{
		$id = mysqli_real_escape_string(self::$con, $data["id"]);
		$name = mysqli_real_escape_string(self::$con, $data["name"]);
		$lastname = mysqli_real_escape_string(self::$con, $data["lastname"]);
		$email = mysqli_real_escape_string(self::$con, $data["email"]);
		$birthdate = mysqli_real_escape_string(self::$con, $data["birthdate"]);
		$sex = mysqli_real_escape_string(self::$con, $data["sex"]);
		$passport = mysqli_real_escape_string(self::$con, $data["passport"]);
		$villa = mysqli_real_escape_string(self::$con, $data["villa"]);
		$departuredate = mysqli_real_escape_string(self::$con, $data["departuredate"]);
		$book_type = mysqli_real_escape_string(self::$con, $data["book_type"]);
		$test_result = mysqli_real_escape_string(self::$con, $data["test_result"]);
		$test_sample = mysqli_real_escape_string(self::$con, $data["test_sample"]);
		$book_family = mysqli_real_escape_string(self::$con, $data["book_family"]);
		$test_type = mysqli_real_escape_string(self::$con, $data["test_type"]);
		$expedient = mysqli_real_escape_string(self::$con, $data["expedient"]);
		$test_date_taken = mysqli_real_escape_string(self::$con, $data["test_date_taken"]);
		$test_date_result = mysqli_real_escape_string(self::$con, $data["test_date_result"]);
		$test_reference = mysqli_real_escape_string(self::$con, $data["test_reference"]);
		$test_method = mysqli_real_escape_string(self::$con, $data["test_method"]);
		$covid_testscol = mysqli_real_escape_string(self::$con, $data["covid_testscol"]);

		$sql = "UPDATE covid_tests " .
			"SET first_name='{$name}', last_name='{$lastname}', email='{$email}', birthdate='{$birthdate}', sex='{$sex}', passport='{$passport}', villa='{$villa}'," .
			"departuredate='{$departuredate}', book_type='{$book_type}', book_family='{$book_family}', test_type='{$test_type}', test_result='{$test_result}', test_sample='{$test_sample}'," .
			"expedient='{$expedient}', test_date_taken='{$test_date_taken}', test_date_result='{$test_date_result}', test_reference='{$test_reference}', test_method='{$test_method}', covid_testscol='{$covid_testscol}', updated_at='" . date('Y-m-d H:i:s'). "'".
			"WHERE id='{$id}'";

		if (!mysqli_query(self::$con, $sql)) {
			self::log('error', 'Unable to insert a record. ' . mysqli_error(self::$con));
			self::flashSet("Error", "No se pudo actualizar su registro, contacte con soporte. // Could not update the record, please contact support.". mysqli_error(self::$con), "danger");
			return;
		}

		self::flashSet("Success", "Se ha guarado con éxito nos pondremos en contacto con usted. // Form successfully saved, we will be in touch with you shortly.", "success");
		header("location: " . self::$rootURL . "/form-edit.php?id=" . $id);
		die();
	}

	public static function showForm($id)
	{
		$id = mysqli_real_escape_string(self::$con, $id);

		$sql = "SELECT * FROM covid_tests WHERE id = '$id'";
		$result = mysqli_query(self::$con, $sql);

		// Associative array
		return mysqli_fetch_assoc($result);
	}
}

$phpPDFQRForms = new phpPDFQRForms();