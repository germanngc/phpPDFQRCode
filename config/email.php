<?php
require_once dirname(__FILE__) . '/../lib/PHPMailer/SMTP.php';
require_once dirname(__FILE__) . '/../lib/PHPMailer/PHPMailer.php';
require_once dirname(__FILE__) . '/../lib/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class phpPDFQREmail extends phpPDFQRConfig
{
	private static $environment = [];
	private static $smtp_user = null;
	private static $smtp_password = null;
	private static $smtp_port = 25;
	private static $smtp_protocol = 'ssl';
	private static $smtp_host = 'localhost';
	private static $sender_name = null;
	private static $sender_mail = null;

	// Do not remove or phpPDFQRConfig construct will be executed twice
	public function __construct() {
		self::$environment = self::parseEnv();

		self::$smtp_user = self::$environment['SMTP_USER'];
		self::$smtp_password = self::$environment['SMTP_PASSWORD'];
		self::$smtp_port = self::$environment['SMTP_PORT'];
		self::$smtp_protocol = self::$environment['SMTP_PROTOCOL'];
		self::$smtp_host = self::$environment['SMTP_HOST'];
		self::$sender_name = self::$environment['SMTP_SENDER_NAME'];
		self::$sender_mail = self::$environment['SMTP_SENDER_MAIL'];
	}

	public function sendEmail($to, $subject, $message)
	{
		$to = 'germanngc@gmail.com';

		try {
			$mail = new PHPMailer(true);
			$mail->isSMTP();
			$mail->setFrom(self::$sender_mail, self::$sender_name);
			$mail->Username = self::$smtp_user;
			$mail->Password = self::$smtp_password;
			$mail->Host = self::$smtp_host;
			$mail->Port = self::$smtp_port;
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = self::$smtp_protocol;
			$mail->addCustomHeader('X-SES-CONFIGURATION-SET');

			// Specify the message recipients.
			$mail->addAddress($to);
		
			// Specify the content of the message.
			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->Body = $message;
			$mail->Send();
		} catch (Exception $e) {
			self::Log('error', 'phpmailerException::Unable to send email. ' . $e->errorMessage());
			return false;
		} catch (\Exception $e) {
			self::Log('error', 'Exception::Unable to send email. ' . $e->errorMessage());
			return false;
		}

		return true;
	}
}

$phpPDFQREmail = new phpPDFQREmail();