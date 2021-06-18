<?php


if($_SERVER['REQUEST_METHOD'] === "POST") { //session start treba i da li je admin pristupio ovome
    require_once "../../config/database.php";
    try {
        if(!isset($_POST['household_name'])){
            $householdInput = "";
        }
        else{
            $householdInput = $_POST['household_name'];
        }
        if(!isset($_POST['email'])){
            $userInput = "";
        }
        else{
            $userInput = trim($_POST['email']);
        }

        $email = '%'.$userInput.'%';



        $db = new Database();
        $conn = $db->connect();
        $stmt = $conn->prepare("select * from users join household_users on users.id_user = household_users.id_user where household_users.id_household = :id_household and users.email like :email;");
        $stmt->bindParam(':id_household', $householdInput);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $data = $stmt->fetchAll();
        if ($stmt->rowCount() === 0)
            exit(json_encode(["error" => 1]));
        else
            exit(json_encode($data));

    } catch (PDOException $e) {
        echo $e->getMessage();
        exit(json_encode(["error" => 1]));
    }

}

