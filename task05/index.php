<?php

$valid = array();
$errors = array();

if ($_POST) {
    require_once './mysql/database.php';

    $courseName = $_POST['courseName'];
    if (!$courseName) {
        $errors['courseName'] = 'Името на предмета е задължително поле.';
    } else if (strlen($courseName) > 150) {
        $errors['courseName'] = 'Името на предмета има максимална дължина от 150 символа.';
    } else {
        $valid['courseName'] = $courseName;
    }

    $instructor = $_POST['instructor'];
    if (!$instructor) {
        $errors['instructor'] = 'Преподавателят е задължително поле.';
    } else if (strlen($instructor) > 200) {
        $errors['instructor'] = 'Преподавателят има максимална дължина от 200 символа.';
    } else {
        $valid['instructor'] = $instructor;
    }

    $description = $_POST['description'];
    if (!$description) {
        $errors['description'] = 'Описанието е задължително поле.';
    } else if (strlen($description) < 10) {
        $errors['description'] = 'Описанието трябва да има минимална дължина от 10 символа.';
    } else {
        $valid['description'] = $description;
    }

    $group = $_POST['group'];
    if (!in_array($group, array('М', 'ПМ', 'ОКН', 'ЯКН'))) {
        $errors['group'] = 'Невалидна група.';
    } else {
        $valid['group'] = $group;
    }

    $credits = $_POST['credits'];
    if (!ctype_digit($credits) || $credits < 1) {
        $errors['credits'] = 'Кредитите трябва да бъдат цяло положително число.';
    } else {
        $valid['credits'] = $credits;
    }

    if(count($errors) === 0) {
        $query = 'INSERT INTO electives (`title`, `description`, `lecturer`) VALUES (?, ?, ?)';
        $stmt = $connection->prepare($query)->execute([
            $_POST['courseName'],
            $_POST['description'],
            $_POST['instructor']
        ]);
    }
}

?>

<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <title>Форма за добавяне на дисциплини</title>
    <style>
        #addCourseForm {
            display: flex;
            flex-direction: column;
            max-width: 50%;
        }

        .input {
            display: flex;
            flex-direction: column;
            padding: 0.5rem;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>

<h2>Форма за добавяне на дисциплини</h2>
<form id="addCourseForm" action="index.php" method="post">

    <div class="input">
        <label for="courseName">Име на предмета:</label>
        <input type="text" id="courseName" name="courseName" maxlength="150" required>
        <?php
        if(isset($errors['courseName'])) {
            echo '<span class="error">' . $errors['courseName'] . '</span>';
        }
        ?>
    </div>

    <div class="input">
        <label for="instructor">Преподавател:</label>
        <input type="text" id="instructor" name="instructor" maxlength="200" required>
        <?php
        if(isset($errors['instructor'])) {
            echo '<span class="error">' . $errors['courseName'] . '</span>';
        }
        ?>
    </div>

    <div class="input">
        <label for="description">Описание:</label>
        <textarea id="description" name="description" rows="4" cols="50" minlength="10" required></textarea>
        <?php
        if(isset($errors['description'])) {
            echo '<span class="error">' . $errors['courseName'] . '</span>';
        }
        ?>
    </div>
    

    <div class="input">
        <label for="group">Група:</label>
        <select id="group" name="group" required>
            <option value="М">М</option>
            <option value="ПМ">ПМ</option>
            <option value="ОКН">ОКН</option>
            <option value="ЯКН">ЯКН</option>
        </select>
        <?php
        if(isset($errors['group'])) {
            echo '<span class="error">' . $errors['courseName'] . '</span>';
        }
        ?>
    </div>

    <div class="input">
        <label for="credits">Кредити:</label>
        <input type="number" id="credits" name="credits" min="1" required>
        <?php
        if(isset($errors['credits'])) {
            echo '<span class="error">' . $errors['courseName'] . '</span>';
        }
        ?>
    </div>

    <div class="input">
        <input type="submit" value="Добави дисциплина">
        <?php
        if(count($errors) !== 0) {
            echo '<span class="error">Error submitting the form</span>';
        } else {
            echo '<span>Form submitted successfully</span>';
        }
        ?>
    </div>
</form>

</body>

</html>