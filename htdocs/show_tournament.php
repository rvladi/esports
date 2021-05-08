<?php
include '../utils/utils.php';
include '../utils/exception_handler.php';

session_start();
$user = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$id = isset($_GET['id']) ? trim($_GET['id']) : NULL;
	check_id($id);

	$dbc = get_database_connection();

	$tournament = get_tournament($dbc, $id, $user);

	close_database_connection($dbc);

	if (isset($_GET['format']) && $_GET['format'] === 'json') {
		include '../views/show_tournament_view_json.php';
	} else {
		include '../views/show_tournament_view.php';
	}
} else {
	throw new Exception('invalid request method');
}
