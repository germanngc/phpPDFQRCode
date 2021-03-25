<?php
// error_reporting(0);
session_start();

class phpPDFQRConfig
{
	private static $envFile = '.env';
	private static $logPath = 'logs/';
	private static $environment = [];
	private static $urlPostFix = '/';

	public static $per_page = 25;
	public static $con = null;
	public static $rootURL = '/';

	function __construct($envFile = null, $urlPostFix = '/')
	{
		self::$envFile = dirname(__FILE__) . '/../' . self::$envFile;
		self::$logPath = dirname(__FILE__) . '/../' . self::$logPath;

		if (!is_null($envFile)) {
			self::$envFile = dirname(__FILE__) . '/../' . $envFile;
		}

		if (!is_null($envFile)) {
			self::$envFile = dirname(__FILE__) . '/../' . $envFile;
		}

		self::$urlPostFix = $urlPostFix;

		self::$environment = self::parseEnv();
		self::$con = self::dbConnect();
		self::$rootURL = self::buildServerUrl(self::$urlPostFix);
		self::auth();
	}

	/**
	 * Auth
	 * 	Check if user is authenticated.
	 * 
	 * @return void
	 */
	private static function Auth()
	{
		$publicURL = [
			self::$rootURL . '/login.php',
			self::$rootURL . '/logout.php',
			self::$rootURL . '/form.php',
			self::$rootURL . '/pdf',
			self::$rootURL . '/favicon.ico'
		];
		$curURL =  '/' . preg_replace("#" . self::$urlPostFix . "#", "", $_SERVER['REQUEST_URI']);
		$curURL = self::$rootURL . preg_replace("/\/\//", "/", $curURL);
		$isClear = false;

		foreach ($publicURL AS $url) {
			if (strpos($curURL, $url) !== false) {
				$isClear = true;
				return;
			}
		}

		if ($isClear) return;

		if (!isset($_SESSION['labsal_user'])) {
			self::log('error', 'An unknown user tried to access this page.');
			self::flashSet("Error", "No existe una session activa. // No active sessions.", "danger");
			session_destroy();
			header("location: " . self::$rootURL . "/login.php");
			die();
		}

		return;
	}

	/**
	 * buildServerUrl
	 * 	Create the server URL for multiple envs
	 */
	private static function buildServerUrl($urlPostFix = '/')
	{
		$urlPostFix = preg_replace(["/\/\//", "/\/$/", "/^\//"], ["/", "", ""], $urlPostFix);
		$urlPostFix = '/' . $urlPostFix;
		self::$urlPostFix = $urlPostFix;

		return preg_replace("/\/$/", "", self::$environment['APP_URL'] .  $urlPostFix); 
	}

	/**
	 * dbConnect
	 * 	Create a Connection
	 * 
	 * @return $con
	 */
	private static function dbConnect()
	{
		$server = self::$environment['DB_HOST'] . ':' . self::$environment['DB_PORT'];
		$database = self::$environment['DB_DATABASE'];
		$user = self::$environment['DB_USERNAME'];
		$password = self::$environment['DB_PASSWORD'];

		if (!$con = mysqli_connect($server, $user, $password, $database)) {
			self::Log("error", "Database connection error " . print_r(mysqli_connect_errno(), true) . '::' . print_r(mysqli_connect_error(), true));
			self::flashSet("Error", "Fallo la conección a la base de datos. // Database connection failure.", "danger");
		}

		return $con;
	}

	/**
	 * dbClose
	 * 	Close a Connection
	 * 
	 * @return void
	 */
	public static function dbClose()
	{
		mysqli_close(self::$con);
	}

	/**
	 * flash
	 * 	Create a flash session
	 */
	public static function flashGet()
	{
		$flashSessions = isset($_SESSION["flash"]) ? $_SESSION["flash"] : [];

		foreach ($flashSessions AS $inx => $alert) {
			echo '<div class="alert alert-dismissible fade show alert-' . $alert["class"] . ' p-3 my-3" id="msg-flash" role="alert">' .
				'<strong>' . $alert["name"] . ': </strong>' . $alert["message"] .
				'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' .
				'</div>';
			unset($_SESSION["flash"][$inx]);
		}
	}

	/**
	 * flash
	 * 	Create a flash session
	 */
	public static function flashSet($name = "", $message = "", $class = "")
	{
		if (!empty($name) && !empty($message) && !empty($class)) {
			$tmpSession = [
				'name' => $name,
				'message' => $message,
				"class" => $class
			];

			if (!isset($_SESSION["flash"])) {
				$_SESSION["flash"] = [];
			}

			array_push($_SESSION["flash"], $tmpSession);
        }
	}

	/**
	 * Log
	 * 	Log events to a file
	 * 
	 * @param $level string
	 * @param $string string
	 * @return void
	 */
	public static function Log($level = 'debug', $string = '')
	{
		file_put_contents(
			self::$logPath . 'log-' . date('Y-m-d') . '.log',
			'[' . $level . '] [' . date('Ymd\THis') . '] ' . $string . PHP_EOL,
			FILE_APPEND
		);
	}

	/**
	 * parseEnv
	 * 	Read the environment file from .env, default or parsed in construct
	 * 
	 * @return array
	 */
	private static function parseEnv()
	{
		$envs = parse_ini_file(self::$envFile, true);

		foreach ($envs AS $env => $val) {
			putenv("{$env}={$val}");
		}

		return $envs;
	}
}

$phpPDFQRConfig = new phpPDFQRConfig();