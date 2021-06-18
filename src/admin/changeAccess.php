<?php
//ADMIN ACCESS ONLY
session_start();
if(isset($_SESSION['id'])){
    if($_SESSION['is_admin'] === "0"){
        header("Location: ../welcome.php");
        exit();
    }
}
else{
    header("Location: ../welcome.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['householdID'])){
    require_once "../../config/database.php";
    $db = new Database();
    $conn = $db->connect();
    $householdID = $_POST['householdID'];
    $stmt = $conn->prepare("SELECT access FROM households WHERE id_household = :householdID");
    $stmt->bindParam(":householdID", $householdID);
    $stmt->execute();
    $result = $stmt->fetch();
    $newAccess = ($result->access === "1") ? "0" : "1";

    $stmt = $conn->prepare("UPDATE households SET access = :newAccess WHERE id_household = :householdID");
    $stmt->bindParam(":householdID", $householdID);
    $stmt->bindParam(":newAccess", $newAccess);
    $stmt->execute();
    if($stmt->rowCount() === 1){
        exit(json_encode(["error"=>0]));
    }
    else{
        exit(json_encode(["error"=>1]));
    }

}
else{
    header("Location: dashboard.php");
    exit();
}

