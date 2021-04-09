<?php
class phpPDFQRUsers extends phpPDFQRConfig
{
	// Do not remove or phpPDFQRConfig construct will be executed twice
	public function __construct() {}

	public static function list($page = 1)
	{
		$offset_1 = 0;
		$offset_2 = self::$per_page;

		if ($page > 1) {
			$offset_1 = ($page - 1) * self::$per_page;
		}

		$limit = "LIMIT {$offset_1}, {$offset_2};";
		$sql = "SELECT * FROM users ORDER BY created_at {$limit}";

		return mysqli_query(self::$con, $sql);
	}

	public static function create($data)
	{
		$username = mysqli_real_escape_string(self::$con, $data["username"]);
		$password = $data["password"];
		$password_confirm = $data["password_confirm"];

		if ($password != $password_confirm) {
			self::Log("error", "Password missmatch while creating user {$username} by " . $_SESSION['labsal_user']);
			self::flashSet("Error", "Las contraseñas no coinciden.", "danger");
			return [];
		}

		// Check if exist
		$sql = "SELECT * FROM users WHERE username = '{$username}' LIMIT 1;";
		$result = mysqli_query(self::$con, $sql);

		if (mysqli_num_rows($result) > 0) {
			self::Log("error", "User {$username} already exist " . $_SESSION['labsal_user']);
			self::flashSet("Error", "El usuario {$username} ya existe.", "danger");
			return [];
		}

		$password_hash = password_hash($password, PASSWORD_DEFAULT);

		$sql = "INSERT INTO users " .
			"(username, password, created_at) " .
			"VALUES " .
			"('{$username}', '{$password_hash}', '" . date('Y-m-d H:i:s'). "');";

		if (!mysqli_query(self::$con, $sql)) {
			self::log('error', 'Unable to insert a record. ' . mysqli_error(self::$con));
			self::flashSet("Error", "No se pudo crear su registro, contacte con soporte.", "danger");
			return;
		}

		self::flashSet("Success", "Usuario creado con éxito.", "success");
		header("location: " . self::$rootURL . "/users.php");
		die();
	}

	public static function edit($itemId)
	{
		// Check if exist
		$sql = "SELECT * FROM users WHERE id = '{$itemId}' LIMIT 1;";
		$result = mysqli_query(self::$con, $sql);

		if (mysqli_num_rows($result) < 1) {
			self::Log("error", "User with id {$itemId} not found by user " . $_SESSION['labsal_user']);
			self::flashSet("Error", "No se encontro usuario con ese identificador.", "danger");
			return [];
		}

		return mysqli_fetch_array($result, MYSQLI_ASSOC);
	}

	public static function update($itemId, $data)
	{
		$id = $data["id"];

		if ($itemId != $id) {
			self::Log("error", "Id Missmatch for itemId={$itemId}/id={$id} by " . $_SESSION['labsal_user']);
			self::flashSet("Error", "Error de congruencia con los identificadores.", "danger");
			return [];
		}

		$password = $data["password"];
		$password_confirm = $data["password_confirm"];

		if ($password != $password_confirm) {
			self::Log("error", "Password missmatch while creating user {$username} by " . $_SESSION['labsal_user']);
			self::flashSet("Error", "Las contraseñas no coinciden.", "danger");
			return [];
		}

		$password_hash = password_hash($password, PASSWORD_DEFAULT);

		$sql = "UPDATE users " .
			"SET password = '{$password_hash}', updated_at = '" . date('Y-m-d H:i:s'). "' " .
			"WHERE id = '{$id}' LIMIT 1;";

		if (!mysqli_query(self::$con, $sql)) {
			self::log('error', 'Unable to update the record id=' . $id . '. ' . mysqli_error(self::$con));
			self::flashSet("Error", "No se pudo actualizar su registro, contacte con soporte.", "danger");
			return;
		}

		self::flashSet("Success", "Usuario actualizado con éxito.", "success");
		header("location: " . self::$rootURL . "/users.php?action=edit&itemId={$id}");
		die();
	}

	public static function delete($itemId)
	{
		$sql = "DELETE FROM users WHERE id = '{$itemId}' LIMIT 1;";
		$result = mysqli_query(self::$con, $sql);

		self::flashSet("Success", "Usuario eliminado con éxito.", "success");
		header("location: " . self::$rootURL . "/users.php?action=list");
		die();
	}
}

$phpPDFQRUsers = new phpPDFQRUsers();

$action = isset($_GET["action"]) ? $_GET["action"] : 'list';
$action = in_array($action, ['list', 'create', 'edit', 'update', 'delete', 'show']) ? $action : 'list';
$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
$page = is_int($page) && $page > 0 ? $page : 1;
$itemId = isset($_GET["itemId"]) ? (int) $_GET["itemId"] : null;
$itemId = is_int($itemId) && $itemId > 0 ? $itemId : null;

$displayData = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	switch ($action) {
		case 'create':
			$displayData = $phpPDFQRUsers::create($_POST);
			break;
		case 'update':
			$displayData = $phpPDFQRUsers::update($itemId, $_POST);
			break;
	}
} else {
	switch ($action) {
		case 'list':
			$displayData = $phpPDFQRUsers::list($page);
			break;
		case 'edit':
			$displayData = $phpPDFQRUsers::edit($itemId);
			break;
		case 'show':
			$displayData = $phpPDFQRUsers::list($page);
			break;
		case 'delete':
			$displayData = $phpPDFQRUsers::delete($itemId);
			break;
	}
}
