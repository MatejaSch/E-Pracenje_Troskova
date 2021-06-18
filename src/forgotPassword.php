<?php
session_start();

//If user is logged redirect him to default user page
if (isset($_SESSION['id'])) {
    if($_SESSION['is_admin'] === "1"){
        header("Location: admin/dashboard.php");
        exit();
    }
    header("Location: user/households.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['forgotEmail'])){
    $email = trim($_POST['forgotEmail']);
    require_once "../config/database.php";
    $db = new Database();
    $conn = $db->connect();
    //Check if user exists and is verified
    $stmt = $conn->prepare("SELECT name, lastname FROM users WHERE email = :email and is_verified = 1");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    if($stmt->rowCount() === 1){ //If user exists
        $result = $stmt->fetch();
        $name = $result->name; //Needed for mail
        $lastname = $result->lastname; //Needed for mail
        //Generating token
        require_once "includes/generateToken.php";
        $token = generateToken(20);
        $stmt = $conn->prepare("UPDATE users SET change_pw_code = :token  WHERE email = :email");
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        if($stmt->rowCount() === 1){
            require_once "forgotPasswordMail.php"; //Send mail with unique link
            exit(json_encode(["error"=>0]));
        }
        else{
            exit(json_encode(["error"=>1]));
        }

    }
    else{ //user doesn't exits
        exit(json_encode(["error"=>2]));
    }
}
else{
    header("Location: welcome.php");
}