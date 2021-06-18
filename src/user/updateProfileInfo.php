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

//Unset $_SESSION['current_household'] value
if(isset($_SESSION['current_household'])){
    unset($_SESSION['current_household']);
}
if(isset($_SESSION['id_role'])){
    unset($_SESSION['current_household']);
}

//Returns data of currently logged user
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['name'], $_POST['lastname'], $_POST['phone'], $_POST['address'])){
    require_once "../../config/database.php";
    $db = new Database();
    $conn = $db->connect();
    $userID = $_SESSION['id'];
    $stmt = $conn->prepare("UPDATE users SET name = :name, lastname = :lastname, phone = :phone, address = :address WHERE id_user = :userID");
    $stmt->bindParam(":userID", $userID);
    $stmt->bindParam(":name", $_POST['name']);
    $stmt->bindParam(":lastname", $_POST['lastname']);
    $stmt->bindParam(":phone", $_POST['phone']);
    $stmt->bindParam(":address",  $_POST['address']);
    $stmt->execute();
    if($stmt->rowCount() === 1){
        exit(json_encode(["error"=>0]));
    }
    else{
        exit(json_encode(["error"=>1]));
    }
}
else{
    header("Location: households.php");
    exit();
}