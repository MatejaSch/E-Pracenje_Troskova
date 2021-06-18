<?php
session_start();

//If user is logged redirect him to default user page
if (isset($_SESSION['id'])) {
    if($_SESSION['is_admin'] === "1"){
        header("Location: admin/dashboard.php");
        exit();
    }else{
        header("Location: user/households.php");
        exit();
    }
}

if(isset($_POST['email'])){
    try {
        require_once "../config/database.php";
        $db = new Database();
        $conn = $db->connect();
        $stmt = $conn->prepare("SELECT name FROM users WHERE email = :email");
        $email = $_POST['email'];
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            exit(json_encode(["error" => "0"]));
        }
        else {
            exit(json_encode(["error" => "1"]));
        }
    }
    catch (PDOException $e){
        echo $e ->getMessage();}
    }
else{
exit(json_encode(["error" => "2"]));
}