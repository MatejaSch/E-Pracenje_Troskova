<?php

session_start();

//Is SESSION value for current household set?
if(!isset($_SESSION['current_household'])){
    //Is user or admin trying to access this page?
    if(isset($_SESSION['id'])){
        if($_SESSION['is_admin'] === "1"){
            header("Location: ../welcome.php");
            exit();
        }
    }
    else{
        header("Location: welcome.php");
        exit();
    }
}
if($_SERVER['REQUEST_METHOD'] === "POST"){
    require_once "../../config/database.php";
    $db = new Database();
    $conn = $db->connect();
    $householdID = $_SESSION['current_household'];
    $stmt = $conn->prepare("SELECT * FROM cost_categories WHERE id_household = :householdID");
    $stmt->bindParam(":householdID", $householdID);
    $stmt->execute();
    $result = $stmt->fetchAll();
    exit(json_encode($result));
}
else{
    header("Location: household.php");
}