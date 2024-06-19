<?php

session_start();

if(!isset($_SESSION['email'])) {
    header('Location: signin.php');
    exit;
}

if(!isset($_SESSION['counter'])) {
    $_SESSION['counter'] = 0;
}

$_SESSION['counter'] += 1;

?>

<html lang="bg-bg">
    <head>
        <title>Home</title>
    </head>
    <body>
        <h1><?php echo $_SESSION['counter']; ?></h1>
    </body>
</html>
