<?php

session_start();

if(isset($_SESSION['email'])) {
    header('Location: home.php');
    exit;
}

if(count($_POST)) {
    include_once '../mysql/database.php';
    global $connection;

    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    $query = 'SELECT * FROM `users` WHERE `email` = ? and `password` = ?';
    $stmt = $connection->prepare($query);
    $result = $stmt->execute([$email, $password]);

    if($result && $stmt->rowCount() === 1) {
        $_SESSION['email'] = $email;
        header('Location: home.php');
        exit;
    }

    echo 'Wrong email or password!';
}

?>

<!DOCTYPE HTML>
<html lang="bg-bg">
    <head>
        <title>Sign In</title>
    </head>
    <body>
        <form method="post" action="signin.php">
            <label for="email">E-Mail:</label>
            <input type="text" name="email" id="email" placeholder="E-Mail Address" />

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Password" />

            <button type="submit">Sign In</button>
        </form>

        <a href="signup.php">Create account</a>
    </body>
</html>