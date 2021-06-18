<?php
class User{

    private $name;
    private $lastname;
    private $email;
    private $address;
    private $phone;
    private $user_password;
    private $is_verified;
    private $verification_code;
    private $is_admin;

    public function __construct($name, $lastname, $email, $address, $phone, $user_password, $is_verified, $verification_code, $is_admin){
        $this->name = $name;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->address = $address;
        $this->phone = $phone;
        $this->user_password = $user_password;
        $this->is_verified = $is_verified;
        $this->verification_code = $verification_code;
        $this->is_admin = $is_admin;
    }


    function insert(){
        require_once "../config/database.php";
        try{
            $db = new Database();
            $conn = $db->connect();
            $stmt = $conn->prepare ("INSERT INTO users(name, lastname, email, address, phone, user_password, is_verified, verification_code, is_admin)
            values (:name, :lastname, :email, :address, :phone, :user_password, :is_verified, :verification_code, :is_admin)");
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":lastname", $this->lastname);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":address", $this->address);
            $stmt->bindParam(":phone", $this->phone);
            $passwordBCrypt = password_hash($this->user_password, PASSWORD_DEFAULT);
            $stmt->bindParam(":user_password", $passwordBCrypt);
            $stmt->bindParam(":is_verified", $this->is_verified);
            $stmt->bindParam(":verification_code", $this->verification_code);
            $stmt->bindParam(":is_admin", $this->is_admin);
            $stmt->execute();
            if($stmt->rowCount() === 1){
                return 1;
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
        return 0;
    }
}