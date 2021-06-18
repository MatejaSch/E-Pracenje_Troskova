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

    $sum = 0;
    $sumForMonth = 0;
    $thisMonth = date("m");
    $thisYear = date("Y");
    $db = new Database();
    $conn = $db->connect();


    $stmt = $conn->prepare("SELECT sum(cost_price) as ukupno FROM cost WHERE id_household = :householdID GROUP BY id_household");
    $stmt->bindParam(":householdID", $_SESSION['current_household']);
    $stmt->execute();
    if($stmt->rowCount() === 1){
        $result = $stmt->fetch();
        $sum = $result->ukupno;
    }


    $stmt = $conn->prepare("SELECT sum(cost_price) as ukupno FROM cost WHERE id_household = :householdID AND MONTH(cost_creating_date) = :thisMonth AND YEAR(cost_creating_date) = :thisYear GROUP BY id_household, MONTH(cost_creating_date)");
    $stmt->bindParam(":householdID", $_SESSION['current_household']);
    $stmt->bindParam(":thisMonth", $thisMonth);
    $stmt->bindParam(":thisYear", $thisYear);
    $stmt->execute();
    if($stmt->rowCount() === 1){
        $result = $stmt->fetch();
        $sumForMonth = $result->ukupno;
    }


    $data = ["sum"=>$sum, "thisMonth"=>$sumForMonth];

    exit(json_encode($data));
}
else{
    header("Location: household.php");
}