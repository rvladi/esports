<?php
$result = [
	'games' => $games,
	'platforms' => $platforms,
	'regions' => $regions,
	'tournaments' => $tournaments,
];

header('Content-Type: application/json; charset=UTF-8');
echo json_encode($result);
