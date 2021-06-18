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

if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['addUser'])){
    require_once "../../config/database.php";
    $db = new Database();
    $conn = $db->connect();
    $addUser = $_POST['addUser']; //users email
    if(!filter_var($addUser, FILTER_VALIDATE_EMAIL)){ //Checks if email format isn't valid
        exit(json_encode(["error"=>"1"]));
    }

    //If email format is valid
    //Check if user exists (and is verified)
    $stmt = $conn->prepare("SELECT id_user, name, lastname FROM users WHERE email = :addUser AND is_verified = 1");
    $stmt->bindParam(":addUser", $addUser);
    $stmt->execute();
    if($stmt->rowCount() === 0){
        exit(json_encode(["error"=>"2"])); //Error user doesn't exist
    }
    else{
        $result = $stmt->fetch();
        $userID = $result->id_user;
        $name = $result->name;
        $lastname = $result->lastname;
    }
    $householdID = $_SESSION['current_household'];
    //Check if user exists already in household you trying to invite him
    $stmt = $conn->prepare("SELECT id_user FROM household_users WHERE id_household = :householdID AND id_user = :userID");
    $stmt->bindParam(":userID", $userID);
    $stmt->bindParam(":householdID", $householdID);
    $stmt->execute();
    if($stmt->rowCount() === 1){
        exit(json_encode(["error"=>"3"])); //Error user is already in this household
    }
    else{
        $stmt = $conn->prepare("SELECT id_user FROM household_user_invitation WHERE id_household = :householdID AND id_user = :userID AND inv_code IS NOT null"); //Check if invitation has already been sent and is not null
        $stmt->bindParam(":userID", $userID);
        $stmt->bindParam(":householdID", $householdID);
        $stmt->execute();

        //Generating code
        require_once "../includes/generateToken.php"; //Include generate token function
        $code = generateToken(5);

        //Updating code if inv has already been sent
        if($stmt->rowCount() === 1){
            require_once "inviteUserMail.php"; //Sends invitation code to mail
            $stmt = $conn->prepare("UPDATE household_user_invitation SET inv_code=:code WHERE id_household = :householdID AND id_user = :userID AND inv_code IS NOT null"); //Check if invitation has already been sent
            $stmt->bindParam(":userID",$userID);
            $stmt->bindParam(":householdID",$householdID);
            $stmt->bindParam(":code",$code);
            $stmt->execute();
            if($stmt->rowCount() === 1){
                exit(json_encode(["error"=>0]));
            }
            else{
                exit(json_encode(["error"=>4]));
            }
        }
        //Inserting code
        else{
            require_once "inviteUserMail.php"; //Sends invitation code to mail
            $stmt = $conn->prepare("INSERT INTO household_user_invitation (id_user, id_household, inv_code) values (:userID, :householdID, :code)");
            $stmt->bindParam(":userID",$userID);
            $stmt->bindParam(":householdID",$householdID);
            $stmt->bindParam(":code",$code);
            $stmt->execute();
            if($stmt->rowCount() === 1){
                exit(json_encode(["error"=>0]));
            }
            else{
                exit(json_encode(["error"=>4]));
            }
        }
    }
}
else{
    header("Location: household.php");
    exit();
}
