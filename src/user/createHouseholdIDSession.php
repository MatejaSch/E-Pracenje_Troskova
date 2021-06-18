<?php

if(isset($_POST['id_household'])){
    try {
        session_start();
        $_SESSION['id_household'] = $_POST['id_household'];
        exit(json_encode(["error" => 0]));
      //  exit(json_encode(["error" => 1]));
       // header();
    }
    catch(Exception $e){  exit(json_encode(["error" => $e ->getMessage()]));}
 //   header('Location: household.php');
}
else{
    exit(json_encode(["error" => "id nije postavljen"]));
}

