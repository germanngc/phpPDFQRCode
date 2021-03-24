<?php
class phpPDFQRLogin extends phpPDFQRConfig
{
	function __construct()
	{
	}

	public static function doLogin($user, $password)
	{
		$labsal_user = mysqli_real_escape_string(self::$con, $user);
		$password = $password;
		$password_hash = password_hash($password, PASSWORD_DEFAULT);

		$sql = "SELECT id, password FROM users WHERE username = '{$labsal_user}' LIMIT 1;";
		$result = mysqli_query(self::$con, $sql);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

		if (!isset($row["password"])) {
			self::log("error", "Unknown user {$labsal_user}");
			self::flashSet("Error", "No existe el usuario {$labsal_user}", "danger");
			// header("location: " . self::$rootURL . "/login.php");
			// return;
		} else if (!password_verify($password, $row["password"])) {
			self::log("error", "password missmatch for {$labsal_user}");
			self::flashSet("Error", "La contraseña no coincide para {$labsal_user}", "danger");
			// header("location: " . self::$rootURL . "/login.php");
			// return;
		} else {
			$_SESSION['labsal_user'] = $labsal_user;
			header("location: " . self::$rootURL . "/");
			return;
		}
	}

	public static function doLogout()
	{
		session_destroy();
		header("location: " . self::$rootURL . "/login.php");
		return;
	}
}

$phpPDFQRLogin = new phpPDFQRLogin();