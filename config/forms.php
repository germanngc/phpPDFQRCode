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
		$reservation_number = mysqli_real_escape_string(self::$con, $data["reservation_number"]);
		$villa = mysqli_real_escape_string(self::$con, $data["villa"]);
		$departuredate = mysqli_real_escape_string(self::$con, $data["departuredate"]);
		$book_type = mysqli_real_escape_string(self::$con, $data["book_type"]);
		$book_family = mysqli_real_escape_string(self::$con, $data["book_family"]);
		$test_type = mysqli_real_escape_string(self::$con, $data["test_type"]);

		$sql = "INSERT INTO covid_tests " .
			"(`first_name`, `last_name`, `email`, `birthdate`, `sex`, `passport`, `reservation_number`, `villa`, `departuredate`, `book_type`, " .
			"`book_family`, `test_type`, `created_at`) " .
			"VALUES " .
			"('{$name}', '{$lastname}', '{$email}', '{$birthdate}', '{$sex}', '{$passport}', '{$reservation_number}', '{$villa}', '{$departuredate}', " .
			"'{$book_type}', '{$book_family}', '{$test_type}', '" . date('Y-m-d H:i:s'). "');";

		if (!mysqli_query(self::$con, $sql)) {
			self::log('error', 'Unable to insert a record. ' . mysqli_error(self::$con));
			self::flashSet("Error", "Could not create the record, please contact support.", "danger");
			return;
		}

		self::flashSet("Success", "Form successfully submited, we will be in touch with you shortly.", "success");
		$_SESSION["tmp_expedient"] = 'RIH' . str_pad(mysqli_insert_id(self::$con), 7, "0", STR_PAD_LEFT);
		header("location: " . self::$rootURL . "/form-thanks.php");
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
		$reservation_number = mysqli_real_escape_string(self::$con, $data["reservation_number"]);
		$departuredate = mysqli_real_escape_string(self::$con, $data["departuredate"]);
		$book_type = mysqli_real_escape_string(self::$con, $data["book_type"]);
		$test_result = mysqli_real_escape_string(self::$con, $data["test_result"]);
		$test_sample = mysqli_real_escape_string(self::$con, $data["test_sample"]);
		$book_family = mysqli_real_escape_string(self::$con, $data["book_family"]);
		$test_type = mysqli_real_escape_string(self::$con, $data["test_type"]);
		$test_date_taken = mysqli_real_escape_string(self::$con, $data["test_date_taken"]);
		$test_date_result = mysqli_real_escape_string(self::$con, $data["test_date_result"]);
		$test_reference = mysqli_real_escape_string(self::$con, $data["test_reference"]);
		$test_method = mysqli_real_escape_string(self::$con, $data["test_method"]);

		$sql = "UPDATE `covid_tests` " .
			"SET `first_name` = '{$name}', `last_name` = '{$lastname}', `email` = '{$email}', `birthdate` = '{$birthdate}', `sex` = '{$sex}', " .
			"`passport` = '{$passport}', `villa` = '{$villa}', `reservation_number` = '{$reservation_number}', `departuredate` = '{$departuredate}', " .
			"`book_type` = '{$book_type}', `book_family` = '{$book_family}', `test_type` = '{$test_type}', `test_result` = '{$test_result}', " .
			"`test_sample` = '{$test_sample}', `test_date_taken` = '{$test_date_taken}', `test_date_result` = '{$test_date_result}', " .
			"`test_reference` = '{$test_reference}', `test_method` = '{$test_method}', `updated_at` = '" . date('Y-m-d H:i:s'). "' ".
			"WHERE `id` = '{$id}' LIMIT 1;";

		if (!mysqli_query(self::$con, $sql)) {
			self::log('error', 'Unable to insert a record. ' . mysqli_error(self::$con));
			self::flashSet("Error", "Could not update the record, please contact support.". mysqli_error(self::$con), "danger");
			return;
		}

		self::flashSet("Success", "Formulario actualizado, Folio: " . 'RIH' . str_pad($id, 7, "0", STR_PAD_LEFT) . ".", "success");
		header("location: " . self::$rootURL . "/");
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