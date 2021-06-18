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
if(isset($_SESSION['id']) && $_SERVER['REQUEST_METHOD'] === "POST"){
    require_once "../../config/database.php";
    $db = new Database();
    $conn = $db->connect();
    $stmt = $conn->prepare("SELECT id_role, household_name, households.id_household as 'household_id' FROM households, household_users WHERE households.id_household = household_users.id_household AND household_users.id_user = :id_user AND access = 1");
    $stmt->bindParam(":id_user", $_SESSION['id']);
    $stmt->execute();
    $households = $stmt->fetchAll();
    exit(json_encode($households));
}
else{
    exit(json_encode(["error"=>1]));
}
