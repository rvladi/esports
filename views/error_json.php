<?php
$result = ['error' => $error];

header('Content-Type: application/json; charset=UTF-8');
echo json_encode($result);
