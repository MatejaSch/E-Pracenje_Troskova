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
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['id_cost'])){
    try {
        require_once "../../config/database.php";
        $db = new Database();
        $conn = $db->connect();

        //DELETE COST
        $stmt = $conn->prepare("DELETE FROM cost WHERE id_cost = :id_cost AND id_household = :householdID");
        $stmt->bindParam(":id_cost", $_POST['id_cost']);
        $stmt->bindParam(":householdID", $_SESSION['current_household']);
        $stmt->execute();
        if ($stmt->rowCount() === 1) {
            exit(json_encode(["error" => 0]));
        } else {
            exit(json_encode(["error" => 1]));
        }
    }
    catch (PDOException $e){ exit(json_encode(["error" => $e->getMessage()]));}
}
else{
    exit(json_encode(["error"=>1]));
}
