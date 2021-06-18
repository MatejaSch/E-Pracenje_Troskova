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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['surname'], $_POST['registerEmail'], $_POST['registerPassword'], $_POST['registerPasswordConfirm'], $_POST['phone'], $_POST['address'])) {

    $name = trim($_POST['name']);
    $lastname = trim($_POST['surname']);
    $email = trim($_POST['registerEmail']);
    $password = $_POST['registerPassword'];
    $passwordConfirm = $_POST['registerPasswordConfirm'];
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);


    $messages = [
        0 => 'Ime mora da sadrži 1-30 slovnih karaktera.',
        1 => 'Prezime mora da sadrži 1-30 slovnih karaktera.',
        2 => 'Email adresa nije valdinog formata.',
        3 => 'Lozinka je prekratka.',
        4 => 'Lozinka je predugačka.',
        5 => 'Lozinka mora da sadrži barem jedno malo slovo.',
        6 => 'Lozinka mora da sadrži barem jedno veliko slovo.',
        7 => 'Lozinka mora da sadrži barem jedan specijalan karakter. ',
        8 => 'Lozinka mora da sadrži barem jedan broj.',
        9 => 'Polje za lozinku je prazno',
        10 => 'Lozinke se ne poklapaju.',
        11 => 'Broj telefona nije ispravan.',
        12 => 'Adresa nije ispravna.',
        13 => 'Adresa je zauzeta'
    ];

    $errors = array();

    //Name must contain characters 1-30, apostrophe characters and no digits
    if ($name === "" || strlen($name) > 30 || preg_match("/[^A-zšđčćžŠĐČĆŽ' ]/", $name)) {
        $errors[] = 0;
    }

    //Surname must contain characters 1-30, no digits, no special characters except '
    if ($lastname === "" || strlen($lastname) > 30 || preg_match("/[^A-zšđčćžŠĐČĆŽ' ]/", $lastname)) {
        $errors[] = 1;
    }

    //Email must be in regular format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 2;
    }

    //
    //Password min 8 characters max 30, must contain uppercase letter, lowercase letter, special character and one number at least
    //
    //Password must be at least 8 and maximum 30 characters long
    if (strlen($password) < 8) {
        $errors[] = 3;
    }
    if (strlen($password) > 30) {
        $errors[] = 4;
    }

    //must contain at least one lowercase letter
    if (!preg_match("/[a-zčćžšđ']/", $password)) {
        $errors[] = 5;
    }

    //must contain at least one uppercase letter
    if (!preg_match('/[A-ZČĆŽŠĐ]/', $password)) {
        $errors[] = 6;
    }

    //must contain at least one special character
    if (!preg_match('/[^a-zA-Z0-9čćžšđČĆŽŠĐ]/', $password)) {
        $errors[] = 7;
    }

    //must contain at least one number
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = 8;
    }

    //musn't be empty
    if (empty($password)) {
        $errors[] = 9;
    }

    //Password must be same as confirmed password
    if ($password !== $passwordConfirm) {
        $errors[] = 10;
    }

    //Phone must be longer than 9 and shorter than 15 numbers
    if (strlen($phone) < 9 || strlen($phone) > 15 || preg_match('/[^0-9+]/', $phone)) {
        $errors[] = 11;
    }

    //Address must not be empty or longer than 50 chars
    if ($address === "" || strlen($address) > 50) {
        $errors[] = 12;
    }

    //Address of VALIDATED user must not be in database
    require_once "../config/database.php";
    $db = new Database();
    $conn = $db->connect();
    $stmt = $conn->prepare("SELECT name from users where email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    if ($stmt->rowCount() === 1) {
        $errors[] = 13;
    }

    //Concatenating error messages in one string
    $errorMessage = "";
    foreach ($errors as $error) {
        $errorMessage .= $messages[$error] . "<br>";
    }
    //var_dump($errorMessage);



    //REGISTER
    //If there are now errors with backend validation insert into database new user
    if (count($errors) === 0) {
        try{
            require_once "includes/generateToken.php"; //Include generate token function
            require_once "user.php";
            //Inserting into database
            $token = generateToken(20);
            $user = new User($name, $lastname, $email, $address, $phone, $password, 0, $token, 0);
            $inserted = $user->insert();
            require_once "sendValidationMail.php";
            if($inserted === 1){
                exit(json_encode(["error"=>0]));
            }
        }
        catch(PDOException $e){
            exit(json_encode(["error"=>1]));
        }
        require_once "sendValidationMail.php"; //sending mail
    } else {
        exit(json_encode(["error"=>1]));
    }

} else {
    exit(json_encode(["error"=>1]));
}


