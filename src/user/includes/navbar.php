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
