<?php
$householdID = $_SESSION['current_household'];
require_once "../../config/database.php";
$db = new Database();
$conn = $db->connect();
$stmt = $conn->prepare("SELECT household_name FROM households WHERE id_household=:id");
$stmt->bindParam(":id",$householdID);
$stmt->execute();
$result = $stmt->fetch();
echo $result->household_name;