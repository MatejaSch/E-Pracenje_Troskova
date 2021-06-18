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
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['name'], $_POST['lastname'], $_POST['phone'], $_POST['address'])){
    require_once "../../config/database.php";
    $db = new Database();
    $conn = $db->connect();
    $userID = $_SESSION['id'];
    $stmt = $conn->prepare("SELECT name, lastname, phone, address FROM users WHERE id_user = :userID");
    $stmt->bindParam(":userID", $userID);
    $stmt->execute();
    $result = $stmt->fetch();
    exit(json_encode($result));
}
else{
    header("Location: households.php");
    exit();
}