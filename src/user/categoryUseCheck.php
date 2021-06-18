<?php
session_start();

//Is SESSION value for current household set?
if (!isset($_SESSION['current_household'])) {
    //Is user or admin trying to access this page?
    if (isset($_SESSION['id'])) {
        if ($_SESSION['is_admin'] === "1") {
            header("Location: ../welcome.php");
            exit();
        }
    } else {
        header("Location: welcome.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['categoryID'])) {

    require_once "../../config/database.php";

    $categoryID = $_POST['categoryID'];
    $householdID = $_SESSION['current_household'];
    $count = 0;

    $db = new Database();
    $conn = $db->connect();


    //Check if category is used in wish
    $stmt = $conn->prepare("SELECT * FROM wishes WHERE id_cost_category = :categoryID AND id_household = :householdID");
    $stmt->bindParam(":categoryID", $categoryID);
    $stmt->bindParam(":householdID", $householdID);
    $stmt->execute();
    $count = $stmt->rowCount();

    //Check if category is used in cost
    $stmt = $conn->prepare("SELECT * FROM cost WHERE id_cost_category = :categoryID AND id_household = :householdID");
    $stmt->bindParam(":categoryID", $categoryID);
    $stmt->bindParam(":householdID", $householdID);
    $stmt->execute();
    $count += $stmt->rowCount();

    if ($count === 0) {
        exit(json_encode(["used" => 0]));
    }
    else {
        exit(json_encode(["used" => 1]));
    }

}
else {
    header("Location: household.php");
}