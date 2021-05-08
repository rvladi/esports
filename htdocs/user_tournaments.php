<?php
include '../utils/utils.php';
include '../utils/exception_handler.php';

session_start();
if (!isset($_SESSION['user_id'])) {
	header('Location: /login.php?location=' . urlencode($_SERVER['REQUEST_URI']));
	exit;
}

$user = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$dbc = get_database_connection();

	$tournaments = get_user_tournaments($dbc, $user);

	close_database_connection($dbc);

	if (isset($_GET['format']) && $_GET['format'] === 'json') {
		include '../views/user_tournaments_view_json.php';
	} else {
		include '../views/user_tournaments_view.php';
	}
} else {
	throw new Exception('invalid request method');
}
