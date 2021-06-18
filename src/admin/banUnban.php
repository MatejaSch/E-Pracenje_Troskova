<?php
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['id_user']) && isset($_POST['banned'])){ //session start treba i da li je admin pristupio ovome
    require_once "../../config/database.php";
    $db = new Database();
    $conn = $db->connect();
    $banned = (int)$_POST['banned']?"0":"1";
    $id_user = $_POST['id_user'];
    $stmt = $conn->prepare("UPDATE users SET is_banned = :banned WHERE id_user = :id_user");
    $stmt->bindParam(":banned", $banned);
    $stmt->bindParam(":id_user", $id_user);
    $stmt->execute();
    if($stmt->rowCount() === 1){
        exit(json_encode(["is_banned"=>$banned, "id_user"=>$id_user]));
    }
    else{
        exit(json_encode(["error"=>"1"]));
    }
}
else{
    header("Location: dashboard.php");
    exit();
}