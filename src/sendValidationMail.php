<?php

require_once "../config/mail_config.php";

//Mail sending and user into database
try {
    $mail->Subject = 'Account verification';
    $server = $_SERVER['SERVER_NAME'];
    $link = $server."/src/verify.php?code=".$token;
    $mail->Body = "Please click on following link to verify your account: <br><a href=$link>$link</a>";
    $mail->addAddress($email,$name ." ". $lastname);
    $mail->send();
    //echo 'Message has been sent';


    //header("Location: welcome.php?mail=sent");
} catch (Exception $e) {
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    exit(json_encode(["error"=>1]));
}


