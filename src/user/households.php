<?php
session_start();

//Is admin trying to access this page or guest?
if(isset($_SESSION['id'])){
    if($_SESSION['is_admin'] === "1"){
        header("Location: ../welcome.php");
        exit();
    }
}
else{
    header("Location: ../welcome.php");
    exit();
}

//Unset $_SESSION['current_household'] value
if(isset($_SESSION['current_household'])){
    unset($_SESSION['current_household']);
}
if(isset($_SESSION['id_role'])){
    unset($_SESSION['current_household']);
}




?>
<?php
require_once "includes/header.php";
require_once "includes/modalAddHousehold.php";
require_once "includes/messages.php";
require_once "includes/navbar.php";
require_once "includes/modalProfileInfo.php";
require_once "includes/dialogModal.php";
?>

<div class="main">
    <div class="gridDefault">
        <div class="grid-item">
            <div class="card card-household">
                <div class="card-body">
                    <div class="card-title">KREIRAJ NOVO DOMAĆINSTVO</div>
                    <div><hr></div>
                    <div><img id="addIconHousehold" class="addIcon" src="../../public/images/icons/plus-circle-fill.svg" alt="add button"></div>
                </div>
            </div>
        </div>
        <div class="grid-item">
            <div class="card card-household join">
                <div class="card-body">
                    <div class="card-title">PRIDRUŽI SE POSTOJEĆEM DOMAĆINSTVU</div>
                    <div style="height: 20px"><hr></div>
                    <form id="joinHouseholdForm" method="post" novalidate>
                        <div class="flex">
                            <label for="household_code">KOD: </label>
                            <input type="text" id="household_code" name="household_code" class="form-control">
                        </div>
                        <button class="btn btn-lg btn-primary"  name="joinHousehold" type="submit">PRIDRUŽI SE!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="grid">

    </div>
</div>

<script src="../../public/js/user/modalAddHousehold.js"></script>
<script src="../../public/js/user/fetchHouseholds.js"></script>
<script src="../../public/js/user/addHouseholdValidation.js"></script>
<script src="../../public/js/user/openHousehold.js"></script>
<script src="../../public/js/user/joinHousehold.js"></script>
<script src="../../public/js/user/modalProfileInfo.js"></script>
<script src="../../public/js/user/modalProfilePassword.js"></script>
<?php require_once "includes/footer.php"?>