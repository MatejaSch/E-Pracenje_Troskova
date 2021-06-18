<?php

session_start();

//If user is logged redirect him to default user page
if (isset($_SESSION['id'])) {
    if($_SESSION['is_admin'] === "1"){
        header("Location: admin/dashboard.php");
        exit();
    }
    else{
        header("Location: user/households.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    <link rel="icon" type="image/png" href="../public/images/favicon.png"/>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../public/css/welcome.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<?php
require_once "includes/messages.php";
require_once "includes/modalResendForgot.php";

//Show message when user verifies account
if(isset($_GET['verified'])){
    if($_GET['verified'] === "1"){
        echo '<script>
            let successBox = $("#successMailVerification");
            successBox.addClass("activeMessage");
            setTimeout(() => {
                successBox.removeClass("activeMessage");
            },7000)
        </script>';
    }
}


if(isset($_GET['changed'])){
    if($_GET['changed'] === "1"){ //Password changed successfully
        echo '<script>
            let messageBox = $("#successPasswordChange");
                if(messageBox.hasClass("activeMessage")){
                    messageBox.removeClass("activeMessage");
                }
                messageBox.addClass("activeMessage");
                setTimeout(() => {
                    messageBox.removeClass("activeMessage");
                },5000);
                $("#modalChangePW").removeClass("activeModal");
        </script>';
    }
    if($_GET['changed'] === "0"){
        echo '<script>
            let messageBox = $("#erorrPasswordChange");
                if(messageBox.hasClass("activeMessage")){
                    messageBox.removeClass("activeMessage");
                }
                messageBox.addClass("activeMessage");
                setTimeout(() => {
                    messageBox.removeClass("activeMessage");
                },5000);
                $("#modalChangePW").removeClass("activeModal");
        </script>';
    }
}

//Show modal for password change if he has valid link
if(isset($_GET['code'])){
    require_once "checkChangePasswordCode.php"; //checks if link is valid and to which account is points
}
?>

<div class="main">
    <section class="row no-gutters welcome">

        <div class="card aboutCard">
            <div class="card-body">
                <h2 class="card-title text-center">E-PRAĆENJE TROŠKOVA</h2>
                <hr class="underline">
                <p class="card-text text-center">E-Praćenje Troškova je web aplikacija koja pruža uslugu evidentiranja troškova svojim korisnicima. Nakon registrovanja korisnici mogu kreirati
                    domaćinstvo i pozvati ostale članove da im se pridruže. Unutar domaćinstva se vodi evidencija o troškovima koje prave sami korisnici.</p>
                <div class="d-flex justify-content-around align-items-center">
                    <div class="card-image"><img class="img-fluid" src="../public/images/graph1.png" alt="graph"></div>
                    <div class="card-image"><img class="img-fluid" src="../public/images/graph2.png" alt="graph"></div>
                    <div class="card-image"><img class="img-fluid" src="../public/images/graph3.png" alt="graph"></div>
                </div>
            </div>
        </div>

        <div class="card loginCard">
            <div class="row no-gutters text-center">
                <div class="formBtn formBtn-active col"><a class="text-reset text-decoration-none">ULOGUJ SE</a></div>
                <div class="formBtn col"><a class="text-reset text-decoration-none">REGISTRUJ SE</a></div>
            </div>
            <div class="card-body">

                <form class="form-active" id="formLogin" action="loginValidation.php" method="post" novalidate>
                    <div class="form-group">
                        <label for="loginEmail">E-MAIL</label>
                        <input class="form-control" id="loginEmail" name="loginEmail" type="email">
                        <small class="invalid-feedback" id="errorLoginEmail"></small>
                    </div>
                    <div class="form-group">
                        <label for="loginPassword">LOZINKA</label>
                        <input class="form-control" id="loginPassword" type="password" name="loginPassword">
                        <small class="invalid-feedback" id="errorLoginPassword"></small>
                    </div>
                    <div id="resend">Zatražite ponovno slanje verifikacionog koda.</div>
                    <div id="forgot">Zaboravili ste lozinku?</div><br>
                    <div class="row">
                        <div class="col text-center">
                            <button class="btn btn-lg btn-primary" name="login" type="submit">ULOGUJ SE!</button>
                        </div>
                    </div>
                </form>

                <form id="formRegister" method="post" action="registerValidation.php" novalidate>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="name">IME</label>
                            <input class="form-control" id="name" name="name" type="text">
                            <small class="invalid-feedback" id="errorName"></small>
                        </div>
                        <div class="form-group col">
                            <label for="surname">PREZIME</label>
                            <input class="form-control" id="surname" name="surname" type="text">
                            <small class="invalid-feedback" id="errorSurname"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="registerEmail">E-MAIL</label>
                        <input class="form-control" id="registerEmail" name="registerEmail" type="email">
                        <small class="invalid-feedback" id="errorRegisterEmail"></small>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="registerPassword">LOZNIKU</label>
                            <input class="form-control" id="registerPassword" name="registerPassword" type="password">
                            <small class="invalid-feedback" id="errorRegisterPassword"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="registerPasswordConfirm">POTVRDI LOZINKU</label>
                            <input class="form-control" id="registerPasswordConfirm" name="registerPasswordConfirm" type="password">
                            <small class="invalid-feedback" id="errorPasswordConfirm"></small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="phone">TELEFON</label>
                            <input class="form-control" id="phone" name="phone" type="tel">
                            <small class="invalid-feedback" id="errorPhone"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">ADRESA</label>
                            <input class="form-control" id="address" name="address" type="text">
                            <small class="invalid-feedback" id="errorAddress"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-center">
                            <button class="btn btn-lg btn-primary" name="register" id="registerButton" type="submit">REGISTRUJ SE!</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </section>
</div>
<?php
require_once "includes/modalChangePW.php";
?>
<script src="../public/js/toggleActiveForm.js"></script>
<script src="../public/js/registerValidation.js"></script>
<script src="../public/js/loginValidation.js"></script>
<script src="../public/js/modalResendForgot.js"></script>
<script src="../public/js/validateResendVerification.js"></script>
<script src="../public/js/forgotPassword.js"></script>
<script src="../public/js/changePWModal.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>
