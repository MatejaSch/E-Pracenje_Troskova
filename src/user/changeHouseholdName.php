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

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['NewHouseholdName'])) {
    try {
        require_once "../../config/database.php";

        $householdID = $_SESSION['current_household'];
        $db = new Database();
        $conn = $db->connect();
        $stmt = $conn->prepare("UPDATE households SET household_name = :newName where id_household =:householdID");
        $stmt->bindParam(":newName", $_POST['NewHouseholdName']);
        $stmt->bindParam(":householdID", $_SESSION['current_household']);
        $stmt->execute();
        if ($stmt->rowCount() === 1) {
            exit(json_encode(["error" => 0]));
        } else {
            exit(json_encode(["error" => 1]));
        }
    }
    catch(PDOException $e){
        exit(json_encode(["error"=>'PDO EXCEPTION']));
    }

} else {
    header("Location: household.php");
}