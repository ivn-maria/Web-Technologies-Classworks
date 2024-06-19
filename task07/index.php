<?php

////Пример:
//$postData = json_encode([
//  'name' => 'Езотерични похвати в ООП',
//    'description' => 'Похвати',
//    'group' => 'ЕП',
//    'credits' => 4
//], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

$postData = file_get_contents('php://input');

$data = json_decode($postData, true, 512, JSON_UNESCAPED_UNICODE);

$errors = [];

$courseName = $data['name'] ?? null;
if (!$courseName) {
    $errors['courseName'] = 'Името на предмета е задължително поле.';
} else if (mb_strlen($courseName) < 2 || strlen($courseName) > 150) {
    $errors['courseName'] = 'Името на предмета ттрябва да е с дължина между 2 и 150 символа, а вие сте въвели ' . mb_strlen($courseName) . ' символа.';
} else {
    $valid['courseName'] = $courseName;
}

$instructor = $data['instructor'] ?? null;
if (!$instructor) {
    $errors['instructor'] = 'Името на преподавателя е задължително поле.';
} else if (mb_strlen($instructor) < 3 || strlen($instructor) > 200) {
    $errors['instructor'] = 'Името на преподавателя ттрябва да е с дължина между 3 и 200 символа, а вие сте въвели ' . mb_strlen($instructor) . ' символа..';
} else {
    $valid['instructor'] = $instructor;
}

$description = $data['description'] ?? null;
if (!$description) {
    $errors['description'] = 'Описанието е задължително поле.';
} else if (mb_strlen($description) < 10) {
    $errors['description'] = 'Описанието трябва да е с дължина поне 10 символа, а вие сте въвели ' . mb_strlen($description) . ' символа.';
} else {
    $valid['description'] = $description;
}

$group = $data['group'] ?? null;
if (!$group) {
    $errors['group'] = 'Групата е задължително поле.';
} else if (!in_array($group, array('М', 'ПМ', 'ОКН', 'ЯКН'))) {
    $errors['group'] = 'Невалидна група, изберете една от М, ПМ, ОКН и ЯКН, а вие сте въвели ' . $group . ' .';
} else {
    $valid['group'] = $group;
}

$credits = $data['credits'] ?? null;
if (!$credits) {
    $errors['credits'] = 'Кредитите са задължително поле.';
} else if (!is_float($credits) && $credits < 1) {
    $errors['credits'] = 'Кредитите трябва да бъдат цяло положително число, а вие сте въвели '. $credits . ' .';
} else {
    $valid['credits'] = $credits;
}

if (empty($errors)) {
    echo json_encode(["success" => true], JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(["success" => false, "errors" => $errors], JSON_UNESCAPED_UNICODE);
}