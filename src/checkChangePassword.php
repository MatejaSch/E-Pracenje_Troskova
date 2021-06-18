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

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    require_once "../config/database.php";
    if (isset($_POST['newPassword'], $_POST['confirmNewPassword'], $_POST['code'])) {

        //Check if code is valid
        $code = $_POST['code'];
        $db = new Database();
        $conn = $db->connect();
        $stmt = $conn->prepare("SELECT name FROM users WHERE change_pw_code = :code");
        $stmt->bindParam(":code", $code);
        $stmt->execute();

        if($stmt->rowCount() === 1){ //If change_pw_code is valid
            $password = $_POST['newPassword'];
            $passwordConfirm =  $_POST['confirmNewPassword'];

            if(passwordCheck($password, $passwordConfirm)){ //if backend check is good update password for user
                try {
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE users SET user_password = :password WHERE change_pw_code = :code");
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':code', $code);
                    $stmt->execute();
                    if ($stmt->rowCount() === 1) {
                        $stmt = $conn->prepare("UPDATE users SET change_pw_code = null WHERE change_pw_code = :code");
                        $stmt->bindParam(":code",$code);
                        $stmt->execute();
                        if($stmt->rowCount() === 1){
                            header("Location: welcome.php?changed=1");
                            exit();
                        }
                        else{
                            header("Location: welcome.php?changed=0");
                            exit();
                        }
                    } else {
                        header("Location: welcome.php?changed=0");
                        exit();
                    }

                } catch (PDOException $e) {
                    //echo $e->getMessage();
                    header("Location: welcome.php?changed=0");
                    exit();
                }
            }
        }
        else{ //Ukoliko je kod nije validan
            header("Location: welcome.php?changed=0");
            exit();
        }


    }
    else {
        header("Location: welcome.php?changed=0");
        exit();
    }
}
else{
    header("Location: welcome.php");
    exit();
}

function passwordCheck($password, $passwordConfirm){
    if (strlen($password) < 8) {
        return false;
    }
    if (strlen($password) > 30) {
        return false;
    }

    //must contain at least one lowercase letter
    if (!preg_match("/[a-zčćžšđ']/", $password)) {
        return false;
    }

    //must contain at least one uppercase letter
    if (!preg_match('/[A-ZČĆŽŠĐ]/', $password)) {
        return false;
    }

    //must contain at least one special character
    if (!preg_match('/[^a-zA-Z0-9čćžšđČĆŽŠĐ]/', $password)) {
        return false;
    }

    //must contain at least one number
    if (!preg_match('/[0-9]/', $password)) {
        return false;
    }


    //Password must be same as confirmed password
    if ($password !== $passwordConfirm) {
        return false;
    }
    return true;
}



