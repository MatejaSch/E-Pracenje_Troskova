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
if($_SERVER['REQUEST_METHOD'] === "POST"){
    require_once "../../config/database.php";
    $db = new Database();
    $conn = $db->connect();
    $stmt = $conn->prepare("SELECT cost_category_name, sum(cost_price) AS suma FROM cost join cost_categories on cost.id_cost_category = cost_categories.id_cost_category WHERE cost.id_household = :householdID GROUP BY cost.id_cost_category ORDER BY suma DESC LIMIT 3");
    $stmt->bindParam(":householdID", $_SESSION['current_household']);
    $stmt->execute();
    $result = $stmt->fetchAll();
    exit(json_encode($result));
}
else{
    header("Location: household.php");
}