<?php

session_start();

if(isset($_SESSION['email'])) {
    header('Location: home.php');
}

function validate_registration_form(string $email, string $password, string $confirmPassword)
{
    global $connection;
    include_once '../mysql/database.php';

    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid e-mail address';
    }

    $query = 'SELECT * FROM users WHERE email = ?';
    $stmt = $connection->prepare($query);
    $result = $stmt->execute([$email]);

    if($result && $stmt->rowCount() === 1) {
        $errors[] = 'This email address already exists';
    }

    if(strlen($password) < 6) {
        $errors[] = 'Password should be at least 6 characters long';
    }

    if($password !== $confirmPassword) {
        $errors[] = 'Password confirmation does not match';
    }

    return $errors;
}

if(count($_POST)) {

    include_once '../mysql/database.php';
    global $connection;

    $errors = validate_registration_form($_POST['email'], $_POST['password'], $_POST['confirm_password']);

    if(count($errors) === 0) {
        $email = $_POST['email'];
        $password = sha1($_POST['password']);

        $query = 'INSERT INTO users (email, password) VALUES (?, ?)';
        $connection->prepare($query)->execute([$email, $password]);

        $_SESSION['email'] = $email;

        header('Location: home.php');
    }
}

?>

<!DOCTYPE HTML>
<html lang="bg-bg">
<head>
    <title>Sign In</title>
</head>
<body>
<form method="post" action="signup.php">
    <label for="email">E-Mail:</label>
    <input type="text" name="email" id="email" placeholder="E-Mail Address" />

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" placeholder="Password" />

    <label for="password_confirmation">Confirm Password:</label>
    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" />

    <button type="submit">Sign Up</button>
</form>

<?php

if(isset($errors) && count($errors)) {
    foreach($errors as $error) {
        echo '<div class="error">' . $error . '</div>';
    }
}

?>

<a href="signin.php">Already have an account?</a>
</body>
</html>