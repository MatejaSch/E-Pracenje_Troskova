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

if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['newCategory'])){

    require_once "../../config/database.php";

    $newCategory = $_POST['newCategory'];
    $householdID = $_SESSION['current_household'];
    //Check if category with same name exists in household
    $db = new Database();
    $conn = $db->connect();
    $stmt = $conn->prepare("SELECT * FROM cost_categories WHERE cost_category_name = :categoryName AND id_household = :householdID");
    $stmt->bindParam(":categoryName", $newCategory);
    $stmt->bindParam(":householdID", $householdID);
    $stmt->execute();
    //If category with same name doesn't exist add it
    if($stmt->rowCount() === 0){
        $stmt = $conn->prepare("INSERT INTO cost_categories(id_household, cost_category_name) values (:householdID, :newCategory)");
        $stmt->bindParam(":newCategory", $newCategory);
        $stmt->bindParam(":householdID", $householdID);
        $stmt->execute();
        if($stmt->rowCount() === 1){
            exit(json_encode(["error"=>0]));
        }
        if($stmt->rowCount() === 1){
            exit(json_encode(["error"=>1]));
        }
    }
    else{
        exit(json_encode(["error"=>2]));
    }
}
else{
    header("Location: household.php");
}