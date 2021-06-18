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

if($_SERVER['REQUEST_METHOD'] && isset($_GET['code']))
    require_once "../config/database.php";
    $db = new Database();
    $conn = $db->connect();
    $code = $_GET['code'];
    $stmt = $conn->prepare("SELECT name FROM users WHERE change_pw_code = :code");
    $stmt->bindParam(":code", $code);
    $stmt->execute();
    if($stmt->rowCount() === 1){ //IF change_pw_code is VALID
        echo "<script>
                window.addEventListener('DOMContentLoaded', () => {
                    changePWModal();
                });
                </script>";
    }
else{
    //Dodati da obriše change_pw_code iz baze i mozda neku poruku da vise link nije validan ukoliko mu se drugi put pristupa
    header("Location: welcome.php");
    exit();
}
?>