<?php

session_start();
if (isset($_SESSION['id'])) {
    if ($_SESSION['is_admin'] === "0") {
        header("Location: ../welcome.php");
        exit();
    }
} else {
    header("Location: ../welcome.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") { //session start treba i da li je admin pristupio ovome
    require_once "../../config/database.php";
    try {
        $db = new Database();
        $conn = $db->connect();
        $stmt = $conn->prepare("SELECT * FROM log_history");
        $stmt->execute();
        $data = $stmt->fetchAll();
        exit(json_encode($data));


    } catch (PDOException $e) {
        echo $e->getMessage();
        exit(json_encode(["error" => 1]));
    }
}