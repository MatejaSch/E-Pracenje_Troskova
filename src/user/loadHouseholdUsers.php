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

require_once "../../config/database.php";

//Check if user is administrator of household
$userID = $_SESSION['id'];
$householdID = $_SESSION['current_household'];
$db = new Database();
$conn = $db->connect();
$stmt = $conn->prepare("SELECT id_role FROM household_users WHERE id_user = :userID AND id_household = :householdID");
$stmt->bindParam(":userID", $userID);
$stmt->bindParam(":householdID", $householdID);
$stmt->execute();
$result = $stmt->fetch();
$roleID = $result->id_role;

//Return all names
if($roleID === "1"){
    $conn = $db->connect();
    $stmt = $conn->prepare("SELECT users.id_user, name, lastname, id_role FROM household_users, users WHERE household_users.id_user = users.id_user AND household_users.id_household = :householdID");
    $stmt->bindParam(":householdID", $householdID);
    $stmt->execute();
    $data = $stmt->fetchAll();
    exit(json_encode($data));
}
else{
    exit(json_encode(["error"=>1]));
}
