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
require_once "includes/header.php";
require_once "includes/messages.php";
require_once "includes/modalCostWish.php";
require_once "includes/dialogModal.php";
require_once "includes/modalProfileInfo.php";
require_once "includes/modalChangeHouseholdName.php";
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"></script>
<!-------------------------------- NAVBAR  ------------------------------->
<nav>
    <div>
        <a href="logout.php"><img class="navIcons" src="../../public/images/icons/box-arrow-left.svg" alt="logout icon"></a>
        <div class="user profileInfo"><img class="navIcons" src="../../public/images/icons/person-circle.svg"  alt="profile icon"><div><?php echo $_SESSION['email']; ?></div></div>
    </div>
    <div class="brand">E-PRAĆENJE TROŠKOVA</div>
    <div>
        <img class="navIcons" id="collapse" src="../../public/images/icons/list.svg"  alt="profile icon">
        <div class="collapse-menu">
            <ul>
                <li><a a href="households.php">POČETNA</a></li>
                <li><a a href="household.php#cost">TROŠKOVI</a></li>
                <li><a a href="household.php#wishes">ŽELJE</a></li>
                <li><a a href="household.php#stats">STATISTIKA</a></li>
                <li class="profileInfo"><img src="../../public/images/icons/person-circle.svg"><a>PROFILNI PODACI</a></li>
                <li><img src="../../public/images/icons/box-arrow-left.svg"><a href="logout.php">LOGOUT</a></li>
            </ul>
        </div>
    </div>
</nav>
<style>
    .activeCollapse{
        display: block;
    }
</style>
<script>
    document.getElementById("collapse").addEventListener("click", () => {
        document.getElementsByClassName("collapse-menu")[0].classList.toggle("activeCollapse");
    });
</script>
<!---------------------------------------------------------------------------->

<div class="main">
    <h1 class="householdNameTitle"><?php  require_once "getHouseholdName.php"; if($_SESSION['id_role'] === "1"):?><img src="../../public/images/icons/pencil-square.svg" alt="edit name" class="editName"><?php endif; ?></h1>
    <div class="del"></div>
    <?php //ONLY FOR HOUSEHOLD ADMIN PART
    if($_SESSION['id_role'] === "1"):
    ?>
    <div class="gridDefault">
        <div class="grid-item">
            <div class="card card-household">
                <div class="card-body">
                    <div class="card-title">ČLANOVI: </div>
                    <div><hr></div>
                    <div class="card-body" id="usersData">

                    </div>
                </div>
            </div>
        </div>
        <div class="grid-item">
            <div class="card card-household">
                <div class="card-body">
                    <div class="card-title">Dodaj korisnika u domaćinstvo</div>
                    <div><hr></div>
                    <form id="inviteUserForm" method="post" novalidate>
                        <div class="form-group">
                            <label for="addUser">EMAIL ADRESA KORISNIKA</label>
                            <input class="form-control" id="addUser" name="addUser" type="text">
                            <small class="invalid-feedback" id="errorAddUser"></small>
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                <button class="btn btn-lg btn-primary" name="inviteUser" id="inviteUser" type="submit">DODAJ KORISNIKA!</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif ;?>
    <div class="grid grid-tools">
        <div class="grid-item">
            <div class="card card-household">
                <div class="card-body">
                    <div class="card-title">KREIRAJ NOVI TROŠAK</div>
                    <div><hr></div>
                    <div><img id="addCost" class="addIcon" src="../../public/images/icons/plus-circle-fill.svg" alt="add button"></div>
                </div>
            </div>
        </div>
        <div class="grid-item">
            <div class="card card-household">
                <div class="card-body">
                    <div class="card-title">KREIRAJ NOVU ŽELJU</div>
                    <div><hr></div>
                    <div><img id="addWish" class="addIcon" src="../../public/images/icons/plus-circle-fill.svg" alt="add button"></div>
                </div>
            </div>
        </div>
        <div class="grid-item">
            <div class="card card-household">
                <div class="card-body">
                    <div class="card-title">KATEGORIJE</div>
                    <div><hr></div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="category">KREIRANE KATEGORIJE</label>
                            <div class="deleteCat">
                                <select id="category"></select>
                                <a id="deleteCategory"><img src="../../public/images/icons/trash.svg"></a>
                            </div>
                            <small id="errorDeleteCat"></small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="category">Dodaj kategoriju</label>
                            <div class="addCat">
                                <input id="newCategory" type="text">
                                <a id="addCategory"><img src="../../public/images/icons/plus-circle.svg"></a>
                            </div>
                            <small id="errorAddCat"></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h3 style="font-size: 30px; margin-top: 30px" class="householdNameTitle" id="costs">TROŠKOVI</h3>
    <div class="costs">
        <div class="info">
            <div>Ukupni troškovi: <b><span id="sum"></span></b> RSD</div>
            <div>Ukupni troškovi za aktuelni mesec: <b><span id="thisMonth"></span></b> RSD</div>
        </div>
        <div class="filters">
            SORTIRAJ:
            <select id="filterCat">
                <option value="0">IZABERI</option>
                <option value="catName">NAZIV KATEGORIJE</option>
                <option value="costValue">TROSAK</option>
            </select>
        </div>
    </div>
    <div class="del"></div>
    <div class="grid grid-costs">
        <!-- COST SECTION -->
    </div>
    <h3 style="font-size: 30px;" class="householdNameTitle" id="wishes">ŽELJE</h3>
    <div class="del"></div>
    <div class="grid grid-wishes">
        <!-- WISHES SECTION -->
    </div>
    <h3 style="font-size: 30px;" class="householdNameTitle" id="stats">STATISTIKA</h3>
    <div class="del"></div>
    <div class="stats">
        <canvas id="topThree" width="400" height="400"></canvas>
    </div>

<div>
<?php //ONLY FOR HOUSEHOLD ADMIN scripts
if($_SESSION['id_role'] === "1"): ?>
<script src="../../public/js/user/inviteUser.js"></script>
<script src="../../public/js/user/removeUser.js"></script>
<script src="../../public/js/user/editHouseholdName.js"></script>
<?php endif;?>
<script src="../../public/js/user/modalAddWish.js"></script>
<script src="../../public/js/user/modalAddCost.js"></script>
<script src="../../public/js/user/loadWishes.js"></script>
<script src="../../public/js/user/loadCosts.js"></script>
<script src="../../public/js/user/loadHouseholdUsers.js"></script>
<script src="../../public/js/user/modalProfileInfo.js"></script>
<script src="../../public/js/user/modalProfilePassword.js"></script>
<script src="../../public/js/user/loadCategories.js"></script>
<script src="../../public/js/user/stats.js"></script>
<script src="../../public/js/user/sumCost.js"></script>
<script>loadHouseholdUsers();</script>
<?php
require_once "includes/footer.php";
?>