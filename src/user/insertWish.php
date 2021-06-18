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
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['wishName'],$_POST['wishPrice'],$_POST['wishCategory'], $_POST['dateExp'], $_POST['categoryID'])){
    try {
        require_once "../../config/database.php";
        $db = new Database();
        $conn = $db->connect();
        $dateNow = date('Y-m-d H:i:s');
        //CREATES NEW WISH
        $stmt = $conn->prepare("INSERT INTO wishes(id_household,id_user,id_cost_category,wish_name,wish_price,wish_expectation, wish_creating_date) 
                            values (:householdID, :idUser, :categoryID , :wishName, :wishPrice, :wishExp, :wish_creating_date)");
        $stmt->bindParam(":householdID", $_SESSION['current_household']);
        $stmt->bindParam(":idUser", $_SESSION['id']);
        $stmt->bindParam(":wishName", $_POST['wishName']);
        $stmt->bindParam(":wishPrice", $_POST['wishPrice']);
        $stmt->bindParam(":wishExp", $_POST['dateExp']);
        $stmt->bindParam(":categoryID", $_POST['categoryID']);
        $stmt->bindParam(":wish_creating_date", $dateNow);
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