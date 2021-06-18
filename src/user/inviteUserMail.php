<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);


//Defining OUR (sender) mail parameters
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
$mail->IsSMTP();
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'studiosuntouchable@gmail.com';         //SMTP username
$mail->Password   = '#MSM#msm2020!Srbo!';                   //SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
$mail->Port       = 587;
$mail->setFrom('studiosuntouchable@gmail.com', 'Untouchable Studios');
$mail->addReplyTo('studiosuntouchable@gmail.com', 'Untouchable Studios');
$mail->isHTML(true);                                  //Set email format to HTML


//Mail sending and user into database
try {
    $mail->Subject = 'Invitation to a household on "E-Pracenje Troskova"';
    $mail->Body = "Code for joining household: ".$code;
    $mail->addAddress($addUser,$name ." ". $lastname);
    $mail->send();
} catch (Exception $e) {
    exit(json_encode(["error"=>1]));
}

