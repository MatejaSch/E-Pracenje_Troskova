<?php
session_start();

//Is admin trying to access this page or guest?
if(isset($_SESSION['id'])){
    if($_SESSION['is_admin'] === "1"){
        header("Location: ../welcome.php");
        exit();
    }
}
else{
    header("Location: ../welcome.php");
    exit();
}
//Unset $SESSION['current_household'] value
if(isset($_SESSION['current_household'])){
    unset($_SESSION['current_household']);
}


if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['household_code'])){
    require_once "../../config/database.php";

    $household_code = trim($_POST['household_code']);
    $userID = $_SESSION['id'];
    $db = new Database();
    $conn = $db->connect();
    //Check if invitation code is connected to user that tries to access to certian household (table household_user_invitation)
    $stmt = $conn->prepare("SELECT inv_code, id_household FROM  household_user_invitation WHERE inv_code = BINARY :code AND id_user = :userID");
    $stmt->bindParam(":code", $household_code);
    $stmt->bindParam(":userID", $userID);
    $stmt->execute();
    $result = $stmt->fetch();
    if($stmt->rowCount() === 1){
        //Remove invitation code
        $householdID = $result->id_household;
        $stmt = $conn->prepare("DELETE FROM household_user_invitation WHERE inv_code = :code AND id_user = :userID");
        $stmt->bindParam(":code", $household_code);
        $stmt->bindParam(":userID", $userID);
        $stmt->execute();
        //Add user to household with role as user (2)
        if($stmt->rowCount() === 1){
            $stmt = $conn->prepare("INSERT INTO household_users(id_household, id_user, id_role) values (:householdID, :userID, 2)");
            $stmt->bindParam(":householdID", $householdID);
            $stmt->bindParam(":userID", $userID);
            $stmt->execute();
            if($stmt->rowCount() === 1){
                exit(json_encode(["error"=>0]));
            }
            else{
                exit(json_encode(["error"=>1]));
            }
        }
        else{
            exit(json_encode(["error"=>1]));
        }
    }
    else{
        exit(json_encode(["error"=>1]));
    }


}
else{
    header("Location: households.php");
    exit();
}