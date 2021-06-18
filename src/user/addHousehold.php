<?php

if($_SERVER['REQUEST_METHOD'] === "POST"){
    if(isset($_POST['householdName'], $_POST['userId'])){
        $householdName = trim($_POST['householdName']);
        if($householdName !== "" && strlen($householdName) <= 50){
            require_once "../../config/database.php";
            $db = new Database();
            $conn = $db -> connect();
            $stmt = $conn->prepare("INSERT INTO households(household_name, access) values (:householdName, 1)"); // Kreira se novi household
            $stmt->bindParam(":householdName", $householdName);
            $stmt->execute();
            if($stmt->rowCount() === 1){
                $householdId = $conn->lastInsertId();
                $userId = $_POST['userId'];
                $stmt = $conn->prepare("INSERT INTO household_users(id_household, id_user, id_role) values (:householdId, :userId, 1)");
                $stmt->bindParam(":householdId", $householdId);
                $stmt->bindParam(":userId", $userId);
                $stmt->execute();
                if($stmt->rowCount() === 1){
                    exit(json_encode(["error"=>0]));
                }
            }
            else{
                exit(json_encode(["error"=>1]));
            }
        }
        else{
            exit(json_encode(["error"=>2]));
        }
    }
    else{
        exit(json_encode(["error"=>3]));
    }
}
else{
    exit(json_encode(["error"=>4]));
}
