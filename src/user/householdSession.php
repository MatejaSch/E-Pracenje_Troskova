<?php
session_start();

//Check if admin or guest are trying to access and redirect them
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


//Check if id_household is set in get
if(isset($_GET['id'])){
    require_once "../../config/database.php";
    $db = new Database();
    $conn = $db->connect();
    //Check if user has access to certain household
    $householdID = $_GET['id'];
    $userID = $_SESSION['id'];
    //$stmt = $conn->prepare("SELECT id_household FROM household_users WHERE id_household = :id_household AND id_user = :id_user");
    $stmt = $conn->prepare("SELECT household_users.id_role, household_users.id_household FROM household_users, households WHERE household_users.id_household = households.id_household AND household_users.id_household = :id_household AND id_user = :id_user AND access = 1");
    $stmt->bindParam(":id_household", $householdID);
    $stmt->bindParam(":id_user", $userID);
    $stmt->execute();
    if($stmt->rowCount() === 1){ //If user has access
        $_SESSION['current_household'] = $householdID;
        $_SESSION['id_role'] = $stmt->fetch()->id_role;
        header("Location: household.php");
        exit();
    }
    else{
        header("Location: households.php");
        exit();
    }
}
else{
    header("Location: households.php");
    exit();
}