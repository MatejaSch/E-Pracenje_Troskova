<?php
session_start();

//If user is logged redirect him to default user page
if (isset($_SESSION['id'])) {
    if($_SESSION['is_admin'] === "1"){
        header("Location: admin/dashboard.php");
        exit();
    }else{
        header("Location: user/households.php");
        exit();
    }
}

// If user exists and not verified (else welcome.php)
// send mail
// and update in database new verification code
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resendEmail'])){
    require_once "../config/database.php";
    $db = new Database();
    $conn = $db->connect();
    $stmt = $conn->prepare("SELECT name, lastname, email, is_verified, verification_code FROM users WHERE email=:email AND is_verified=0");
    $stmt->bindParam(":email", $_POST['resendEmail']);
    $stmt->execute();

    //If user is registered and not verified send mail with new code
    if($stmt->rowCount() === 1){

        $result = $stmt->fetch();
        $name = $result->name;
        $lastname = $result->lastname;
        $email = $result->email;
        $is_verified = $result->is_verified;

        require_once "includes/generateToken.php"; //Include generate token function
        $token = generateToken(20);

        require_once "sendValidationMail.php";             //SEND MAIL

        try{
            $db = new Database();
            $conn = $db->connect();
            $stmt = $conn->prepare ("UPDATE users SET verification_code=:code WHERE email=:email");
            $stmt->bindParam(":code", $token);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            if($stmt->rowCount() === 1){
                exit(json_encode(["error" => 0]));
            }
        }
        catch(PDOException $e){
            exit(json_encode(["error" => 1]));
        }

    }
    else{
        exit(json_encode(["error" => 1]));
    }
}

else{
    header("Location: welcome.php");
}

