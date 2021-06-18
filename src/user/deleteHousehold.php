<?php

session_start();
//Is admin trying to access this page or guest?
if (isset($_SESSION['id'])) {
    if ($_SESSION['is_admin'] === "1") {
        header("Location: ../welcome.php");
        exit();
    }
} else {
    header("Location: ../welcome.php");
    exit();
}

//Unset $_SESSION['current_household'] value
if (isset($_SESSION['current_household'])) {
    unset($_SESSION['current_household']);
}
if (isset($_SESSION['id_role'])) {
    unset($_SESSION['current_household']);
}


if (isset($_SESSION['id'], $_POST['householdID']) && $_SERVER['REQUEST_METHOD'] === "POST") {
    require_once "../../config/database.php";
    $db = new Database();
    $conn = $db->connect();
    //Check if user ($_SESSION['id']) is admin of household that he wants to delete
    $stmt = $conn->prepare("DELETE FROM household_users WHERE id_user = :userID AND id_household = :householdID AND id_role = 1");
    $stmt->bindParam(":userID", $_SESSION['id']);
    $stmt->bindParam(":householdID", $_POST['householdID']);
    $stmt->execute();
    if($stmt->rowCount() === 1){
        exit(json_encode(["error" => 0]));
    }
    else{
        exit(json_encode(["error" => 1]));
    }
}
else {
    exit(json_encode(["error" => 1]));
}
