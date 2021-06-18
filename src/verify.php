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

if(isset($_GET['code'])){
    require_once "../config/database.php";
    $code = $_GET['code'];
    $db = new Database();
    $conn = $db->connect();
    $stmt = $conn->prepare ("SELECT is_verified FROM users WHERE verification_code = :code");
    $stmt->bindParam(":code", $code);
    $stmt->execute();
    if($stmt->rowCount() === 0){
        header("Location: welcome.php");
        exit();
    }
    $stmt = $conn->prepare ("UPDATE users SET is_verified = 1, verification_code = NULL where verification_code = :code");
    $stmt->bindParam(":code", $code);
    $stmt->execute();
    if($stmt->rowCount() === 1){
        header("Location: welcome.php?verified=1");
        exit();
    }
}
else{
    header("Location: welcome.php");
    exit();
}