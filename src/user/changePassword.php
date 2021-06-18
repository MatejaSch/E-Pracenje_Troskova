<?php
session_start();

//Is admin trying to access this page or guest?
if(isset($_SESSION['id'])){
    if($_SESSION['is_admin'] === "1"){
        header("Location: ../welcome.php");
        exit();
    }
}
else{
    header("Location: ../welcome.php");
    exit();
}


//Returns data of currently logged user
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['oldPassword'], $_POST['newPassword'], $_POST['newPasswordConfirm'])){
    require_once "../../config/database.php";
    $db = new Database();
    $conn = $db->connect();
    $userID = $_SESSION['id'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $newPasswordConfirm = $_POST['newPasswordConfirm'];

    $stmt = $conn->prepare("SELECT user_password FROM users WHERE id_user = :userID");
    $stmt->bindParam(":userID", $userID);
    $stmt->execute();
    $result = $stmt->fetch();
    $password = $result->user_password;

    if(password_verify($oldPassword, $password)){
        if($newPassword === $newPasswordConfirm){
            $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET user_password = :newPassword WHERE id_user = :userID");
            $stmt->bindParam(":userID", $userID);
            $stmt->bindParam(":newPassword", $newPassword);
            $stmt->execute();
            if($stmt->rowCount() === 1){
                exit(json_encode(["error"=>0]));
            }
            else{
                exit(json_encode(["error"=>1]));
            }
        }
        else{
            exit(json_encode(["error"=>1]));
        }
    }
    else{
        exit(json_encode(["error"=>2]));
    }
}
else{
    header("Location: households.php");
    exit();
}
