<?php
session_start();

class phpPDFQRConfig
{
	private static $envFile = '.env';
	private static $logPath = 'logs/';
	private static $environment = [];

	public static $con = null;
	public static $rootURL = '/';

	function __construct($envFile = null, $urlPrefix = '/')
	{
		self::$envFile = dirname(__FILE__) . '/../' . self::$envFile;
		self::$logPath = dirname(__FILE__) . '/../' . self::$logPath;

		if (!is_null($envFile)) {
			self::$envFile = dirname(__FILE__) . '/../' . $envFile;
		}

		if (!is_null($envFile)) {
			self::$envFile = dirname(__FILE__) . '/../' . $envFile;
		}

		self::$environment = self::parseEnv();
		self::$con = self::dbConnect();
		// self::$rootURL = self::$environment['APP_URL'] .  $urlPrefix;
		self::$rootURL = self::buildServerUrl($urlPrefix);
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
			self::$rootURL . '/pdf'
		];
		$curURL = self::$rootURL . $_SERVER['REQUEST_URI'];
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
			self::flashSet("Error", "No existe una session activa.", "danger");
			session_destroy();
			header("location: " . self::$rootURL . "/login.php");
			return;
		}

		return;
	}

	/**
	 * buildServerUrl
	 * 	Create the server URL for multiple envs
	 */
	private static function buildServerUrl($urlPrefix = '/')
	{
		$urlPrefix = preg_replace(["/\/\//", "/\/$/", "/^\//"], ["/", "", ""], $urlPrefix);

		return self::$environment['APP_URL'] .  $urlPrefix; 
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

		return mysqli_connect($server, $user, $password, $database);
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