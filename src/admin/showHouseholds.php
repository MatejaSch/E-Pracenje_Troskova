<?php


if($_SERVER['REQUEST_METHOD'] === "POST") { //session start treba i da li je admin pristupio ovome
    require_once "../../config/database.php";
    try {
        if(!isset($_POST['household_name'])){
            $householdInput = "";
        }
        else{
            $householdInput = trim($_POST['household_name']);
        }
        if(!isset($_POST['user_name'])){
            $userInput = "";
        }
        else{
            $userInput = trim($_POST['user_name']);
        }


        $has = '%' . $householdInput . '%';
        $email = '%' .$userInput.'%';


        $db = new Database();
        $conn = $db->connect();
       $stmt = $conn->prepare("
                        select h.id_household,h.household_name,h.access from users u
join household_users hu on hu.id_user = u.id_user
join households h on h.id_household = hu.id_household
where u.email like :email_name and h.household_name like :has
GROUP by h.id_household
        ");

        $stmt->bindParam(':has', $has);
        $stmt->bindParam(':email_name', $email);
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
