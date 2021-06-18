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
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['costName'], $_POST['costPrice'], $_POST['costCategory'], $_POST['costDescription'])){
    try {
        require_once "../../config/database.php";
        $db = new Database();
        $conn = $db->connect();
        $dateNow = date('Y-m-d H:i:s');
        //CREATES NEW COST
        $stmt = $conn->prepare("INSERT INTO cost(id_household, id_user, id_cost_category, cost_name, cost_price, cost_description, cost_creating_date) 
                            values (:householdID, :idUser, :categoryID , :costName, :costPrice, :costDescription, :creationDate)");
        $stmt->bindParam(":householdID", $_SESSION['current_household']);
        $stmt->bindParam(":idUser", $_SESSION['id']);
        $stmt->bindParam(":categoryID", $_POST['costCategory']);
        $stmt->bindParam(":costName", $_POST['costName']);
        $stmt->bindParam(":costPrice", $_POST['costPrice']);
        $stmt->bindParam(":costDescription", $_POST['costDescription']);
        $stmt->bindParam(":creationDate", $dateNow);
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