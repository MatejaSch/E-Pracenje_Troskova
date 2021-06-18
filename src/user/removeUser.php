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

if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['removeID'])){
    ////Check if id_user that we want to delete belongs to admins household
    require_once "../../config/database.php";
    $householdID = $_SESSION['current_household'];
    $userID = $_POST['removeID'];
    $db = new Database();
    $conn = $db->connect();
    $stmt = $conn->prepare("SELECT id_user FROM household_users WHERE id_user = :userID AND id_household = :householdID");
    $stmt->bindParam(":userID", $userID);
    $stmt->bindParam(":householdID", $householdID);
    $stmt->execute();
    if($stmt->rowCount() === 1){
        $stmt = $conn->prepare("DELETE FROM household_users WHERE id_user = :userID AND id_household = :householdID");
        $stmt->bindParam(":userID", $userID);
        $stmt->bindParam(":householdID", $householdID);
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
    header("Location: household.php");
    exit();
}