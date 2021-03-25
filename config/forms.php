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
		$type_test = mysqli_real_escape_string(self::$con, $data["type_test"]);

		$sql = "INSERT INTO covid_tests " .
			"(first_name, last_name, email, birthdate, sex, passport, villa, departuredate, book_type, book_family, test_type, created_at) " .
			"VALUES " .
			"('{$name}', '{$lastname}', '{$email}', '{$birthdate}', '{$sex}', '{$passport}', '{$villa}', '{$departuredate}', '{$book_type}', '{$book_family}', '{$type_test}', '" . date('Y-m-d H:i:s'). "');";

		if (!mysqli_query(self::$con, $sql)) {
			self::log('error', 'Unable to insert a record. ' . mysqli_error(self::$con));
			self::flashSet("Error", "No se pudo crear su registro, contacte con soporte. // Could not create the record, please contact support.", "danger");
			return;
		}

		self::flashSet("Success", "Se ha creado con éxito nos pondremos en contacto con usted. // Form successfully submited, we will be in touch with you shortly.", "success");
		header("location: " . self::$rootURL . "/form.php");
		die();
	}
}

$phpPDFQRForms = new phpPDFQRForms();