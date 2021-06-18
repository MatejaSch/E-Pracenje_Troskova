<?php
//Load Composer's autoloader

require '../vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);


//Defining OUR (sender) mail parameters
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
$mail->IsSMTP();
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'studiosuntouchable@gmail.com';         //SMTP username
$mail->Password   = '';                   //SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
$mail->Port       = 587;
$mail->setFrom('studiosuntouchable@gmail.com', 'Untouchable Studios');
$mail->addReplyTo('studiosuntouchable@gmail.com', 'Untouchable Studios');
$mail->isHTML(true);                                  //Set email format to HTML

