<?php
class phpPDFQRConfig
{
	private static $envFile = '.env';
	private static $logPath = 'logs/';
	private static $environment = [];
	private static $con = null;

	function __construct($envFile = null)
	{
		self::$envFile = dirname(__FILE__) . '/../' . self::$envFile;
		self::$logPath = dirname(__FILE__) . '/../' . self::$logPath;

		if (!is_null($envFile)) {
			self::$envFile = dirname(__FILE__) . '/../' . $envFile;
		}

		self::$environment = self::parseEnv();
		self::$con = self::dbConnect();
	}

	/**
	 * Create a Connection
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

	/**
	 * Log
	 * 	Log events to a file
	 * 
	 * @param $level string
	 * @param $string string
	 * @return void
	 */
	private static function Log($level = 'debug', $string = '')
	{
		file_put_contents(
			self::$logPath . 'log-' . date('Y-m-d') . '.log',
			'[' . $level . '] [' . date('Ymd\THis') . '] ' . $string . PHP_EOL,
			FILE_APPEND
		);
	}
}

$phpPDFQRConfig = new phpPDFQRConfig();