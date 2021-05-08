<?php
include '../utils/utils.php';
include '../utils/exception_handler.php';

session_start();
if (!isset($_SESSION['user_id'])) {
	header('Location: /login.php?location=' . urlencode($_SERVER['REQUEST_URI']));
	exit;
}

$user = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id = isset($_POST['id']) ? trim($_POST['id']) : NULL;
	check_id($id);

	$dbc = get_database_connection();

	delete_tournament($dbc, $id, $user);

	close_database_connection($dbc);

	if (isset($_POST['format']) && $_POST['format'] === 'json') {
		include '../views/delete_tournament_view_result_json.php';
	} else {
		include '../views/delete_tournament_view_result.php';
	}
} else {
	throw new Exception('invalid request method');
}