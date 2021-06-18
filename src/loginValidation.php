<?php
session_start();

//If user is logged redirect him to default user page
if (isset($_SESSION['id'])) {
    if($_SESSION['is_admin'] === "1"){
        header("Location: admin/dashboard.php");
        exit();
    }
    header("Location: user/households.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loginEmail'],$_POST['loginPassword'])) {

    $email = trim($_POST['loginEmail']);
    $password = $_POST['loginPassword'];

    //Checking if filter is right format
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        exit(json_encode(["error"=>'email']));
    }

    require_once "../config/database.php";
    try{
        $db = new Database();
        $conn = $db->connect();
        $stmt = $conn->prepare("SELECT id_user, email, is_admin, user_password, is_verified FROM users WHERE email = :email AND is_banned = 0"); //check if user is registered and not banned
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if($stmt->rowCount() === 1){ //if exists
            $result = $stmt->fetch();
            $passwordEncrypted = $result->user_password;
            if(password_verify($password,$passwordEncrypted)) { //if passwords match
                if ($result->is_verified === "1") { //if verified
                    $_SESSION["id"] = $result->id_user;
                    $_SESSION["email"] = $result->email;
                    $_SESSION["is_admin"] = $result->is_admin;
                    //LOGING (log history)
                    require_once "log.php";
                    if ($result->is_admin === "0") {
                        exit(json_encode(["error" => 0]));
                    }
                    if ($result->is_admin === "1") {
                        exit(json_encode(["error" => 3]));
                    }
                }
                else{
                    exit(json_encode(["error" => 'NIJE VERIFIKOVAN'])); //if not verified
                }
            }
            else{
                exit(json_encode(["error"=>'Sifra/email nije uredu']));
            }
        }
        else{
            exit(json_encode(["error"=>'NIJE REGISTROVAN'])); //if not registered
        }


    }
    catch(PDOException $e){
        exit(json_encode(["error"=>'PDO EXCEPTION']));
    }


}
else {
    header("Location: welcome.php");
}