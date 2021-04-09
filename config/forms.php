<?php
class phpPDFQRForms extends phpPDFQRConfig
{
	// Do not remove or phpPDFQRConfig construct will be executed twice
	public function __construct() {}

	public static function createForm($data)
	{
		$data["parent_id"] = null;

		if (!$form_id = self::insertForm(self::$con, $data)) {
			self::flashSet("Error", "Could not create the record, please contact support.", "danger");
			return;
		}

		$party_members_id = false;

		if (isset($data['party_members']) && is_array($data['party_members'])) {
			$party_members_id = [
				'success' => [],
				'errors' => []
			];
			$party_member = [
				'parent_id' => $form_id,
				'name' => '',
				'lastname' => '',
				'email' => $data['email'],
				'birthdate' => '',
				'sex' => '',
				'passport' => '',
				'reservation_number' => $data['reservation_number'],
				'villa' => $data['villa'],
				'book_type' => $data['book_type'],
				'test_type' => $data['test_type']
			];

			foreach ($data["party_members"] AS $member) {
				$party_member['name'] = $member['name'];
				$party_member['lastname'] = $member['lastname'];
				$party_member['birthdate'] = $member['birthdate'];
				$party_member['sex'] = $member['sex'];
				$party_member['passport'] = $member['passport'];
				$party_member['test_type'] = $member['test_type'];

				if ($party_form_id = self::insertForm(self::$con, $party_member)) {
					$party_members_id['success']['RIH' . str_pad($party_form_id, 7, "0", STR_PAD_LEFT)] = $party_member;
				} else {
					$party_members_id['errors'][] = $party_member;
				}
			}
		}

		self::flashSet("Success", "Form successfully submited, we will be in touch with you shortly.", "success");
		$_SESSION["tmp_expedient"] = 'RIH' . str_pad($form_id, 7, "0", STR_PAD_LEFT);
		$_SESSION["tmp_expedient_result"] = $party_members_id;
		header("location: " . self::$rootURL . "/form-thanks.php");
		die();
	}

	public static function updateForm($data)
	{
		$id = mysqli_real_escape_string(self::$con, $data["id"]);
		$name = mysqli_real_escape_string(self::$con, $data["name"]);
		$lastname = mysqli_real_escape_string(self::$con, $data["lastname"]);
		$email = mysqli_real_escape_string(self::$con, $data["email"]);
		$birthdate = mysqli_real_escape_string(self::$con, date("Y-m-d", strtotime($data["birthdate"])));
		$sex = mysqli_real_escape_string(self::$con, $data["sex"]);
		$passport = mysqli_real_escape_string(self::$con, $data["passport"]);
		$villa = mysqli_real_escape_string(self::$con, $data["villa"]);
		$reservation_number = mysqli_real_escape_string(self::$con, $data["reservation_number"]);
		$symptoms = mysqli_real_escape_string(self::$con, implode(";", isset($data["symptoms"]) ? $data["symptoms"] : []));
		$book_type = mysqli_real_escape_string(self::$con, $data["book_type"]);
		$test_result = mysqli_real_escape_string(self::$con, $data["test_result"]);
		$test_sample = mysqli_real_escape_string(self::$con, $data["test_sample"]);
		$test_type = mysqli_real_escape_string(self::$con, $data["test_type"]);
		$patient_day_number = mysqli_real_escape_string(self::$con, $data["patient_day_number"]);
		$test_date_taken = mysqli_real_escape_string(self::$con, date("Y-m-d", strtotime($data["test_date_taken"])));
		$test_date_result = mysqli_real_escape_string(self::$con, date("Y-m-d", strtotime($data["test_date_result"])));
		$test_reference = mysqli_real_escape_string(self::$con, $data["test_reference"]);
		$test_method = mysqli_real_escape_string(self::$con, $data["test_method"]);
		$pcr_observations = mysqli_real_escape_string(self::$con, implode(";", isset($data["pcr_observations"]) ? $data["pcr_observations"] : []));
		$pcr_observations_sample = mysqli_real_escape_string(self::$con, implode(";", isset($data["pcr_observations_sample"]) ? $data["pcr_observations_sample"] : []));
		$pcr_interpretation = mysqli_real_escape_string(self::$con, $data["pcr_interpretation"]);

		$sql = "UPDATE `covid_tests` " .
			"SET `first_name` = '{$name}', `last_name` = '{$lastname}', `email` = '{$email}', `birthdate` = '{$birthdate}', `sex` = '{$sex}', " .
			"`passport` = '{$passport}', `villa` = '{$villa}', `reservation_number` = '{$reservation_number}', " .
			"`symptoms` = '{$symptoms}', `book_type` = '{$book_type}', `test_type` = '{$test_type}', " .
			"`patient_day_number` = '{$patient_day_number}', `test_result` = '{$test_result}', `test_sample` = '{$test_sample}', " .
			"`test_date_taken` = '{$test_date_taken}', `test_date_result` = '{$test_date_result}', `test_reference` = '{$test_reference}', " .
			"`test_method` = '{$test_method}', `pcr_observations` = '{$pcr_observations}', `pcr_observations_sample` = '{$pcr_observations_sample}', " .
			"`pcr_interpretation` = '{$pcr_interpretation}', `updated_at` = '" . date('Y-m-d H:i:s'). "' ".
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

		$sql = "SELECT * FROM `covid_tests` WHERE id = '$id'";
		$result = mysqli_query(self::$con, $sql);

		// Associative array
		return mysqli_fetch_assoc($result);
	}

	private static function insertForm($con, $data)
	{
		$parent_id = mysqli_real_escape_string($con, isset($data["parent_id"]) ? intval($data["parent_id"]) : 'null');
		$name = mysqli_real_escape_string($con, $data["name"]);
		$lastname = mysqli_real_escape_string($con, $data["lastname"]);
		$email = mysqli_real_escape_string($con, $data["email"]);
		$birthdate = mysqli_real_escape_string($con, date("Y-m-d", strtotime($data["birthdate"])));
		$sex = mysqli_real_escape_string($con, $data["sex"]);
		$passport = mysqli_real_escape_string($con, $data["passport"]);
		$reservation_number = mysqli_real_escape_string($con, $data["reservation_number"]);
		$villa = mysqli_real_escape_string($con, $data["villa"]);
		$book_type = mysqli_real_escape_string($con, $data["book_type"]);
		$test_type = mysqli_real_escape_string($con, $data["test_type"]);

		$sql = "INSERT INTO covid_tests " .
			"(`parent_id`, `first_name`, `last_name`, `email`, `birthdate`, `sex`, `passport`, `reservation_number`, `villa`, " .
			"`book_type`, `test_type`, `created_at`) " .
			"VALUES " .
			"({$parent_id}, '{$name}', '{$lastname}', '{$email}', '{$birthdate}', '{$sex}', '{$passport}', '{$reservation_number}', " .
			"'{$villa}', '{$book_type}', '{$test_type}', '" . date('Y-m-d H:i:s'). "');";

		if (!mysqli_query($con, $sql)) {
			self::log('error', 'Unable to insert a record. ' . mysqli_error($con));
			return false;
		}

		return mysqli_insert_id(self::$con);
	}
}

$phpPDFQRForms = new phpPDFQRForms();