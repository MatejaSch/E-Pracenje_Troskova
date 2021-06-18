<?php
session_start();
session_destroy();
$location = "/E_pracenje_troskova/src/welcome.php";
header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);
exit();