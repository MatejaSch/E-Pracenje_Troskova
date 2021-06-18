<?php
//ADMIN ACCESS ONLY
session_start();
if(isset($_SESSION['id'])){
    if($_SESSION['is_admin'] === "0"){
        header("Location: ../welcome.php");
        exit();
    }
}
else{
    header("Location: ../welcome.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="../../public/images/favicon.png" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../public/css/dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title>Dashboard</title>
</head>
<body>
<?php include("modalChangePassword.php"); ?>
<div id="succesChangingPassword" class="successMessage">
    <h3>Uspešno!</h3>
    <div>Šifra je uspešno promenjena!</div>
</div>
    <h1 class="title">ADMIN DASHBOARD</h1>
<a href="logout.php"><img src="../../public/images/icons/box-arrow-left.svg">LOGOUT!</a>
    <form class="filters" id="filters" method="post" action="">
        <label for="household">IME DOMAĆINSTVA: </label><input type="text" name="householdName" id="household">
        <label for="email">EMAIL:   </label><input type="text" name="userName" id="email">
        <input type="submit" id="formSubmit" value="FILTER!">
    </form>
    <div class="main">


        <!-- MODEL -->
       <!-- <div class="household-users">
            <div class="household">
                <div class="household-name"><span>Petrovici </span><span>ID: 14</span><span>ACCESS: 1</span><span>CHANGE ACCESS</span></div>
                <div class="user"><span>Mateja </span><span>ID: 14</span><span>CHANGE PASSWORD</span><span>BAN</span></div>
                <div class="user">Mijat<span>ID: 14</span><span>CHANGE PASSWORD</span><span>BAN</span></div>
                <div class="user">Djordje<span>ID: 14</span><span>CHANGE PASSWORD</span><span>BAN</span></div>
            </div>
        </div>-->
    </div>
    <h2>Istorija logovanja</h2>
    <div class="logHistoryBlock table" id="logHistoryBlock">
        <table id="LogHistoryTable">
            <thead>
            <tr>
                <th scope="col">ID_Korisnik</th>
                <th scope="col">IP adresa</th>
                <th scope="col">Browser</th>
                <th scope="col">Datum</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

<script src="fetchUsers.js"></script>
<script src="fetchLogHistory.js"></script>
</body>
</html>
