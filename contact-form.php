<?php

//if(!$_POST) exit;

// Email address verification, do not edit.
function isEmail($email) {
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
}

if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

$name     = 'Ismael';//$_POST['name'];
$email    = 'ismaelocho@gmail.com';//$_POST['email'];
$subject  = 'DVD de color naranja';//$_POST['subject'];
$comments = 'saludos con el paquete naranja';//$_POST['comments'];
$phone = '322 210 0264';//$_POST['phone'];

if(trim($name) == '') {
	echo '<div class="error_message">Attention! You must enter your name.</div>';
	exit();
} else if(trim($email) == '') {
	echo '<div class="error_message">Attention! Please enter a valid email address.</div>';
	exit();
} else if(!isEmail($email)) {
	echo '<div class="error_message">Attention! You have enter an invalid e-mail address, try again.</div>';
	exit();
}

if(trim($subject) == '') {
	echo '<div class="error_message">Attention! Please enter a subject.</div>';
	exit();
} else if(trim($comments) == '') {
	echo '<div class="error_message">Attention! Please enter your message.</div>';
	exit();
} 

if(get_magic_quotes_gpc()) {
	$comments = stripslashes($comments);
}
if(get_magic_quotes_gpc()) {
	$phone = stripslashes($phone);
}

//$address = "example@yourdomain.com";
$address = "germanngc@gmail.com";




// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
include('config/SMTP.php');
include('config/PHPMailer.php');
include('config/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Replace sender@example.com with your "From" address.
// This address must be verified with Amazon SES.
$sender = 'info@premieradventures.com.mx';
$senderName = 'Laboratorio Salazar';

// Replace recipient@example.com with a "To" address. If your account
// is still in the sandbox, this address must be verified.
$recipient = 'germanngc@gmail.com';

// Replace smtp_username with your Amazon SES SMTP user name.
$usernameSmtp = 'AKIA.....';
$passwordSmtp = 'BOuB.....';

// Specify a configuration set. If you do not want to use a configuration
// set, comment or remove the next line.
// $configurationSet = 'ConfigSet';

// If you're using Amazon SES in a region other than US West (Oregon),
// replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP
// endpoint in the appropriate region.
$host = 'email-smtp.us-east-2.amazonaws.com';
$port = 587;

// The subject line of the email
$subject = 'Formulario de Contacto: '.$subject;

// The plain-text body of the email


// The HTML-formatted body of the email
$e_body = "<b>De:</b> $name <br />" . PHP_EOL . PHP_EOL;
$e_phone = "<b>Telefono:</b> $phone <br />" . PHP_EOL . PHP_EOL;
$e_reply = "<b>Email:</b> $email <br />". PHP_EOL . PHP_EOL;
$e_content = "<b>Mensaje:</b> $comments ";

$msg = wordwrap( $e_body . $e_phone . $e_reply . $e_content, 70 );


$bodyText =  $msg;
$logo = '<img src="https://laboratoriosalazar.com.mx/wp-content/uploads/2020/07/cropped-logo_final.png" alt="Laboratorio Salazar" width="200">';
$bodyHtml = $logo.'<h1>Laboratorio Salazar</h1><p>'.$msg.'</p>';

$mail = new PHPMailer(true);

try {
    // Specify the SMTP settings.
    $mail->isSMTP();
    $mail->setFrom($sender, $senderName);
    $mail->Username   = $usernameSmtp;
    $mail->Password   = $passwordSmtp;
    $mail->Host       = $host;
    $mail->Port       = $port;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = 'tls';
    $mail->addCustomHeader('X-SES-CONFIGURATION-SET');

    // Specify the message recipients.
    $mail->addAddress($recipient);
	$mail->addBCC('ismaelocho@gmail.com');
    // You can also add CC, BCC, and additional To recipients here.

    // Specify the content of the message.
    $mail->isHTML(true);
    $mail->Subject    = $subject;
    $mail->Body       = $bodyHtml;
    $mail->AltBody    = $bodyText;
    $mail->Send();


	echo "<fieldset>";
	echo "<div id='success_page'>";
	echo "<h1>Correo enviado correctamente.</h1>";
	echo "<p>Gracias <strong>$name</strong>, su mensaje nos ha sido enviado.</p>";
	echo "</div>";
	echo "</fieldset>";
} catch (phpmailerException $e) {
    echo "Ocurrió un error. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
} catch (Exception $e) {
    echo "Correo no enviado. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
}

