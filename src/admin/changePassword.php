<?php

if($_SERVER['REQUEST_METHOD'] === "POST") { //session start treba i da li je admin pristupio ovome
    require_once "../../config/database.php";
    if (isset($_POST['user_id']) && isset($_POST['new_password'])) {
        try {
            $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $id_user = $_POST['user_id'];

            $db = new Database();
            $conn = $db->connect();
            $stmt = $conn->prepare("update users u set u.user_password = :password where u.id_user=:id_user");
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':id_user', $id_user);
            $stmt->execute();
            if ($stmt->rowCount() === 0) {
                exit(json_encode(["error" => 1]));
            }
            else{
                exit(json_encode(["error" => 2]));
            }

        } catch (PDOException $e) {
            //echo $e->getMessage();
            exit(json_encode(["error" => 1]));
        }
    } else {
        exit(json_encode(["error" => 1]));
    }
}



