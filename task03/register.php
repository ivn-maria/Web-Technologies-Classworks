<?php

$data = file_get_contents("php://input");
$data = json_decode($data, true);
var_dump($data);
