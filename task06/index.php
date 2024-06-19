<?php

session_start();

if(isset($_SESSION['email'])) {
    header('Location: home.php');
    exit;
}

header('Location: signin.php');